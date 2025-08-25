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
            'rule_code'        => 'required|unique:result_action,rule_code|max:50',
            'rule_description' => 'required|max:255',
            'rule_type'        => 'nullable|max:50',
            'lead_status_id'   => 'required|integer',
            //'result_code'      => 'required|integer',
            'status'           => 'required|in:Yes,No',
        ]);
        //dd($request->all());

        try {
            $action = new ResultAction();
            $action->rule_code        = $request->rule_code;
            $action->rule_description = $request->rule_description;
            $action->rule_type        = $request->rule_type ?? null;

            //callback/park/general fields
            $action->distribution_priority             = $request->distribution_priority ?? null;
            $action->after_1st_park_priority           = $request->after_1st_park_priority ?? null;
            $action->after_2nd_park_priority           = $request->after_2nd_park_priority ?? null;
            $action->distribution_time                 = $request->distribution_time ?? null;
            $action->after_1st_park_time               = $request->after_1st_park_time ?? null;
            $action->after_2nd_park_time               = $request->after_2nd_park_time ?? null;

            //general extra fields
            $action->attempts_general                  = $request->attempts_general ?? null;
            $action->after_1st_park_priority_general   = $request->after_1st_park_priority_general ?? null;
            $action->after_2nd_park_priority_general   = $request->after_2nd_park_priority_general ?? null;
            $action->apply_condition                   = $request->apply_condition_general ? 1 : 0;
            $action->park_cycle_before_dead            = $request->park_cycle_before_dead ?? null;

            //other fields
            $action->rule_based     = $request->rule_based ?? null;
            $action->num_attempts   = $request->num_attempts ?? null;
            $action->callback       = $request->callback ?? null;
            $action->dead           = $request->dead ?? null;
            $action->lead_status_id = $request->lead_status_id;
            $action->next_dist      = $request->next_dist ?? null;
            $action->result_code    = $request->result_code;

            $action->status = $request->status === "Yes" ? 1 : 0;
            $action->created_by = Auth::id();
            $action->updated_by = Auth::id();

            //dd($action);

            $action->save();

            return (object)[
                'status' => 201,
                'info'   => $action->id
            ];

        } catch (\Exception $e) {
            return (object)[
                'status' => 424,
                'error'  => $e->getMessage()
            ];
        }
    }

    /**
     * Update an existing ResultAction
     */
    public function resultActionUpdate($request, $id)
    {
        $request->validate([
            'rule_code'        => 'required|max:50|unique:result_action,rule_code,' . $id,  
            'rule_description' => 'required|max:255',
            'rule_type'        => 'nullable|max:50',
            'lead_status_id'   => 'required|integer',
            'status'           => 'required|in:Yes,No',
        ]);

        try {
            
            $action = ResultAction::findOrFail($id);

            $action->rule_code        = $request->rule_code;
            $action->rule_description = $request->rule_description;
            $action->rule_type        = $request->rule_type ?? $action->rule_type;

            //callback/park/general fields
            $action->distribution_priority             = $request->distribution_priority ?? $action->distribution_priority;
            $action->after_1st_park_priority           = $request->after_1st_park_priority ?? $action->after_1st_park_priority;
            $action->after_2nd_park_priority           = $request->after_2nd_park_priority ?? $action->after_2nd_park_priority;
            $action->distribution_time                 = $request->distribution_time ?? $action->distribution_time;
            $action->after_1st_park_time               = $request->after_1st_park_time ?? $action->after_1st_park_time;
            $action->after_2nd_park_time               = $request->after_2nd_park_time ?? $action->after_2nd_park_time;

            //general extra fields
            $action->attempts_general                  = $request->attempts_general ?? $action->attempts_general;
            $action->after_1st_park_priority_general   = $request->after_1st_park_priority_general ?? $action->after_1st_park_priority_general;
            $action->after_2nd_park_priority_general   = $request->after_2nd_park_priority_general ?? $action->after_2nd_park_priority_general;
            $action->apply_condition                   = $request->apply_condition_general ? 1 : $action->apply_condition;
            $action->park_cycle_before_dead            = $request->park_cycle_before_dead ?? $action->park_cycle_before_dead;

            //other fields
            $action->rule_based     = $request->rule_based ?? $action->rule_based;
            $action->num_attempts   = $request->num_attempts ?? $action->num_attempts;
            $action->callback       = $request->callback ?? $action->callback;
            $action->dead           = $request->dead ?? $action->dead;
            $action->lead_status_id = $request->lead_status_id;
            $action->next_dist      = $request->next_dist ?? $action->next_dist;
            $action->result_code    = $request->result_code;

            $action->status = $request->status === "Yes" ? 1 : 0;
            $action->updated_by = Auth::id();
            $action->save();

            return (object)[
                'status' => 200,
                'info'   => $action->id
            ];

        } catch (\Exception $e) {
            return (object)[
                'status' => 424,
                'error'  => $e->getMessage()
            ];
        }
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
