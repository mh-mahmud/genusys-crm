<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ScheduleCallService;
use App\Helpers\Helper;

class ScheduleCallController extends Controller
{
    protected $scheduleCallService;

    public function __construct(ScheduleCallService $scheduleCallService)
    {
        $this->scheduleCallService = $scheduleCallService;
        $this->middleware('auth');
    }

    # ---------------- Schedule Call Section ---------------- #

    public function index(Request $request)
    {
        $calls = $this->scheduleCallService->getAllCalls($request);
        return view('schedule-call.index', compact('calls'));
    }

    public function create()
    {
        $data = Helper::scheduleCallDropDownData(); // doctor, lead, user list if needed
        return view('schedule-call.create', $data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'lead_id'       => 'required|integer',
            'user_id'       => 'required|integer',
            'schedule_time' => 'required|date_format:Y-m-d H:i:s',
            'phone_number'  => 'nullable|string|max:50',
            'home_phone'    => 'nullable|string|max:50',
            'work_phone'    => 'nullable|string|max:50',
            'call_note'     => 'nullable|string|max:255',
        ]);

        $result = $this->scheduleCallService->store($request->all());

        if ($result->status == 201) {
            Helper::storeLog("Schedule Call created successfully", "Schedule Call", "Create");
            return redirect()->route('schedule-call-list')->with('success', 'Schedule Call created successfully.');
        }

        return back()->with('error', 'Failed to create Schedule Call.');
    }

    public function show($id)
    {
        $call = $this->scheduleCallService->findById($id);
        return view('schedule-call.show', compact('call'));
    }

    public function edit($id)
    {
        $data['call'] = $this->scheduleCallService->findById($id);
        $data += Helper::scheduleCallDropDownData();

        return view('schedule-call.edit', $data);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'schedule_time' => 'required|date_format:Y-m-d H:i:s',
            'call_note'     => 'nullable|string|max:255',
            'status'        => 'required|in:0,1',
        ]);

        $result = $this->scheduleCallService->update($request->all(), $id);

        if ($result->status == 200) {
            Helper::storeLog("Schedule Call updated successfully", "Schedule Call", "Update");
            return redirect()->route('schedule-call-list')->with('success', 'Schedule Call updated successfully.');
        }

        return back()->with('error', 'Failed to update Schedule Call.');
    }

    public function destroy($id)
    {
        $result = $this->scheduleCallService->delete($id);

        if ($result->status == 200) {
            Helper::storeLog("Schedule Call deleted successfully", "Schedule Call", "Delete");
            return redirect()->route('schedule-call-list')->with('success', 'Schedule Call deleted successfully.');
        }

        return back()->with('error', 'Failed to delete Schedule Call.');
    }
}
