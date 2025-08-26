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
            'status' => 'required|in:1,0',
        ]);
        //dd($request->all());

        try {
            $action = new ResultAction();

        // Common
        $action->rule_code        = $request->rule_code;
        $action->rule_description = $request->rule_description;
        $action->rule_type        = $request->rule_type ?? null;

        // Callback fields
        if ($request->rule_type === 'Callback') {
            $action->distribution_priority   = $request->distribution_priority_callback;
            $action->after_1st_park_priority = $request->after_1st_park_priority_callback;
            $action->after_2nd_park_priority = $request->after_2nd_park_priority_callback;
        }

        // Park fields
        if ($request->rule_type === 'PARK') {
            $action->distribution_time   = $request->distribution_time_park;
            $action->after_1st_park_time = $request->after_1st_park_min_park;
            $action->after_2nd_park_time = $request->after_2nd_park_min_park;
            $action->distribution_priority   = $request->distribution_priority_park;
            $action->after_1st_park_priority = $request->after_1st_park_priority_park;
            $action->after_2nd_park_priority = $request->after_2nd_park_priority_park;
        }

        // General fields
        if ($request->rule_type === 'General') {
            $action->distribution_time   = $request->distribution_time_general;
            $action->after_1st_park_time = $request->after_1st_park_min_general;
            $action->after_2nd_park_time = $request->after_2nd_park_min_general;
            $action->distribution_priority   = $request->distribution_priority_general;
            $action->after_1st_park_priority = $request->after_1st_park_priority_general;
            $action->after_2nd_park_priority = $request->after_2nd_park_priority_general;
            $action->attempts_general                = $request->attempts_general;
            $action->after_1st_park_priority_general = $request->after_1st_park_priority_99;
            $action->after_2nd_park_priority_general = $request->after_2nd_park_priority_99;
            $action->apply_condition                 = $request->apply_condition_general ? 1 : 0;
            $action->park_cycle_before_dead          = $request->park_cycle_before_dead;
           
        }

        // Other common fields
        $action->rule_based     = $request->rule_based ?? null;
        $action->num_attempts   = $request->num_attempts ?? null;
        $action->callback       = $request->callback ?? null;
        $action->dead           = $request->dead ?? null;
        $action->lead_status_id = $request->lead_status_id;
        $action->next_dist      = $request->next_dist ?? null;
        $action->result_code    = $request->result_code;

        $action->status     = $request->status === "1" ? 1 : 0;
        $action->created_by = Auth::id();
        $action->updated_by = Auth::id();

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
        'status' => 'required|in:1,0',
    ]);
    //dd($request->all());

    try {
        $action = ResultAction::findOrFail($id);

        // Common
        $action->rule_code        = $request->rule_code;
        $action->rule_description = $request->rule_description;
        $action->rule_type        = $request->rule_type ?? $action->rule_type;

        // reset fields before rule type change
        $action->distribution_time   = null;
        $action->after_1st_park_time = null;
        $action->after_2nd_park_time = null;
        $action->distribution_priority   = null;
        $action->after_1st_park_priority = null;
        $action->after_2nd_park_priority = null;
        $action->attempts_general                  = null;
        $action->after_1st_park_priority_general   = null;
        $action->after_2nd_park_priority_general   = null;
        $action->apply_condition                   = null;
        $action->park_cycle_before_dead            = null;

        // Callback fields
        if ($request->rule_type === 'Callback') {
            $action->distribution_priority   = $request->distribution_priority_callback;
            $action->after_1st_park_priority = $request->after_1st_park_priority_callback;
            $action->after_2nd_park_priority = $request->after_2nd_park_priority_callback;
        }

        // Park fields
        if ($request->rule_type === 'PARK') {
            $action->distribution_time   = $request->distribution_time_park;
            $action->after_1st_park_time = $request->after_1st_park_min_park;
            $action->after_2nd_park_time = $request->after_2nd_park_min_park;
            $action->distribution_priority   = $request->distribution_priority_park;
            $action->after_1st_park_priority = $request->after_1st_park_priority_park;
            $action->after_2nd_park_priority = $request->after_2nd_park_priority_park;
        }

        // General fields
        if ($request->rule_type === 'General') {
            // $action->distribution_time   = $request->distribution_time_general;
            // $action->after_1st_park_time = $request->after_1st_park_min_general;
            // $action->after_2nd_park_time = $request->after_2nd_park_min_general;
            // $action->distribution_priority   = $request->distribution_priority_general;
            // $action->after_1st_park_priority = $request->after_1st_park_priority_general;
            // $action->after_2nd_park_priority = $request->after_2nd_park_priority_general;
            // $action->attempts_general        = $request->attempts_general;
            // $action->apply_condition         = $request->apply_condition_general ? 1 : 0;
            // $action->park_cycle_before_dead  = $request->park_cycle_before_dead;


            $action->distribution_time   = $request->distribution_time_general;
            $action->after_1st_park_time = $request->after_1st_park_min_general;
            $action->after_2nd_park_time = $request->after_2nd_park_min_general;
            $action->distribution_priority   = $request->distribution_priority_general;
            $action->after_1st_park_priority = $request->after_1st_park_priority_general;
            $action->after_2nd_park_priority = $request->after_2nd_park_priority_general;
            $action->attempts_general                = $request->attempts_general;
            $action->after_1st_park_priority_general = $request->after_1st_park_priority_99;
            $action->after_2nd_park_priority_general = $request->after_2nd_park_priority_99;
            $action->apply_condition                 = $request->apply_condition_general ? 1 : 0;
            $action->park_cycle_before_dead          = $request->park_cycle_before_dead;
        }

        // Other common fields
        $action->rule_based     = $request->rule_based ?? $action->rule_based;
        $action->num_attempts   = $request->num_attempts ?? $action->num_attempts;
        $action->callback       = $request->callback ?? $action->callback;
        $action->dead           = $request->dead ?? $action->dead;
        $action->lead_status_id = $request->lead_status_id;
        $action->next_dist      = $request->next_dist ?? $action->next_dist;
        $action->result_code    = $request->result_code;

        $action->status     = $request->status === "1" ? 1 : 0;
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
