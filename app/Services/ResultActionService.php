<?php

namespace App\Services;

use App\Models\ResultAction;
use Exception;
use Illuminate\Support\Facades\Auth;

class ResultActionService
{
 
    public function resultActionList($request)
    {
        $sql = ResultAction::query();

        $data = $request->all();

        if (!empty($data['search'])) {
            $sql->where('rule_code', 'like', '%' . $data['search'] . '%')
                ->orWhere('rule_description', 'like', '%' . $data['search'] . '%');
        }

        if (isset($data['paginate']) && $data['paginate'] == false) {
            return $sql->orderBy('id', 'DESC')->get();
        } else {
            return $sql->orderBy('id', 'DESC')->paginate(config('constants.ROW_PER_PAGE'));
        }
    }


    public function resultActionStore($request)
    {
        $request->validate([
            'rule_code'        => 'required|unique:result_action,rule_code|max:255',
            'rule_description' => 'required|max:255',
            'rule_based'       => 'required',
            'num_attempts'     => 'nullable|integer',
            'lead_status_id'   => 'required|integer',
            'result_code'      => 'required|integer',
            'status'           => 'required|boolean',
        ]);

        $data = $request->all();

      

        try {
            $action = new ResultAction();
            //dd($action);
            $action->rule_code        = $data['rule_code'];
            $action->rule_description = $data['rule_description'];
            $action->rule_based       = $data['rule_based'];
            $action->num_attempts     = $data['num_attempts'] ?? null;
            $action->callback         = $data['callback'] ?? null;
            $action->dead             = $data['dead'] ?? null;
            $action->lead_status_id   = $data['lead_status_id'];
            $action->next_dist        = $data['next_dist'] ?? null;
            $action->result_code      = $data['result_code'];
            $action->status           = $data['status'];
            $action->created_by       = Auth::id();
            
            $action->save();
        } catch (Exception $e) {
            return (object)[
                'status' => 424,
                'error'  => $e->getMessage()
            ];
        }

        return (object)[
            'status' => 201,
            'info'   => $action->id
        ];
    }

    /**
     * Update an existing ResultAction
     */
    public function resultActionUpdate($request, $id)
    {
        $request->validate([
            'rule_code'        => 'required|unique:result_action,rule_code,' . $id . '|max:255',
            'rule_description' => 'required|max:255',
            'rule_based'       => 'required',
            'num_attempts'     => 'nullable|integer',
            'lead_status_id'   => 'required|integer',
            'result_code'      => 'required|integer',
            'status'           => 'required|boolean',
        ]);

        $data = $request->all();

        try {
            $action = ResultAction::findOrFail($id);
            $action->rule_code        = $data['rule_code'];
            $action->rule_description = $data['rule_description'];
            $action->rule_based       = $data['rule_based'];
            $action->num_attempts     = $data['num_attempts'] ?? null;
            $action->callback         = $data['callback'] ?? null;
            $action->dead             = $data['dead'] ?? null;
            $action->lead_status_id   = $data['lead_status_id'];
            $action->next_dist        = $data['next_dist'] ?? null;
            $action->result_code      = $data['result_code'];
            $action->status           = $data['status'];
            $action->updated_by       = Auth::id();

            $action->save();
        } catch (Exception $e) {
            return (object)[
                'status' => 424,
                'error'  => $e->getMessage()
            ];
        }

        return (object)[
            'status' => 200,
            'info'   => $action->id
        ];
    }

    /**
     * Get a ResultAction by ID
     */
    public function getResultActionById($id)
    {
        return ResultAction::findOrFail($id);
    }

    /**
     * Delete a ResultAction by ID
     */
    public function resultActionDelete($id)
    {
        try {
            $action = ResultAction::findOrFail($id);
            $action->delete();
        } catch (Exception $e) {
            return (object)[
                'status' => 424,
                'error'  => $e->getMessage()
            ];
        }

        return (object)[
            'status' => 200
        ];
    }
}
