<?php

namespace App\Services;

use App\Models\ScheduleCall;

class ScheduleCallService
{
   public function getAllCalls($request)
{
    $sql = ScheduleCall::query()
        ->leftJoin('leads', 'schedule_call.lead_id', '=', 'leads.id')
        ->leftJoin('users', 'schedule_call.user_id', '=', 'users.id')
        ->select(
            'schedule_call.*',
            'leads.first_name as lead_first_name',
            'leads.last_name as lead_last_name',
            'users.first_name as user_first_name',
            'users.last_name as user_last_name'
        );

    $data = $request->all();

   
    if (!empty($data['search'])) {
        $sql->where(function ($q) use ($data) {
            $q->where('schedule_call.phone_number', 'like', '%' . $data['search'] . '%')
              ->orWhere('schedule_call.home_phone', 'like', '%' . $data['search'] . '%')
              ->orWhere('schedule_call.work_phone', 'like', '%' . $data['search'] . '%')
              ->orWhere('schedule_call.call_note', 'like', '%' . $data['search'] . '%')
              ->orWhere('schedule_call.lead_id', 'like', '%' . $data['search'] . '%')
              ->orWhere('leads.first_name', 'like', '%' . $data['search'] . '%')
              ->orWhere('leads.last_name', 'like', '%' . $data['search'] . '%')
              ->orWhere('users.first_name', 'like', '%' . $data['search'] . '%')
              ->orWhere('users.last_name', 'like', '%' . $data['search'] . '%');
        });
    }

   
    if (isset($data['paginate']) && $data['paginate'] == false) {
        return $sql->orderBy('schedule_call.schedule_time', 'desc')->get();
    } else {
        return $sql->orderBy('schedule_call.schedule_time', 'desc')
                   ->paginate(config('constants.ROW_PER_PAGE'));
    }
}



    public function store(array $data)
    {
        $call = ScheduleCall::create($data);
        return (object)['status' => $call ? 201 : 500];
    }

    public function findById($id)
    {
        return ScheduleCall::findOrFail($id);
    }

    public function update(array $data, $id)
    {
        $call = ScheduleCall::findOrFail($id);
        $updated = $call->update($data);
        return (object)['status' => $updated ? 200 : 500];
    }

    public function delete($id)
    {
        $call = ScheduleCall::findOrFail($id);
        $deleted = $call->delete();
        return (object)['status' => $deleted ? 200 : 500];
    }
}
