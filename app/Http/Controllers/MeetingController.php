<?php

namespace App\Http\Controllers;

use App\Models\Meeting;
use Illuminate\Http\Request;
use App\Services\MeetingService;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Models\Lead;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Helpers\Helper;

class MeetingController extends Controller
{
    protected $meetingService;

    public function __construct(MeetingService $meetingService)
    {
        $this->meetingService = $meetingService;
        $this->middleware('auth');
    }

    //listing of the meetings
    public function index()
    {
        $meetings = $this->meetingService->getAllMeetings();
        //$meeting = $meetings->first();  
        return view('meetings.index', compact('meetings'));
    }


    // show creating a new meeting
    public function create()
    {
        //$leads = DB::table('leads')->select('id', 'first_name','last_name','email')->get();
        //$users = DB::table('users')->select('id', 'username','email')->get();
        if (Auth::user()->user_type === 'admin') {
            $leads = DB::table('leads')
            ->select('id', 'first_name', 'last_name', 'email')
            ->where('lead_status', 1)
            ->get();
        } else {
            $leads = DB::table('leads')
            ->select('id', 'first_name', 'last_name', 'email')
            ->where('lead_status', 1)
            ->where('created_by', Auth::user()->id)
            ->get();
        }
        $users = DB::table('users')
        ->select('id', 'username', 'email')
        ->where('status', '1')
        ->get();
        return view('meetings.create', compact('leads', 'users'));
    }

    // store a newly created meeting
    public function store(Request $request)
    {   

        $validator = Validator::make($request->all(), [
            'meeting_subject' => 'required|string|max:191',
            'meeting_description' => 'nullable|string',
            'meeting_date' => 'required|date',
            'meeting_link' => 'nullable|url',
            'attachments' => 'nullable|file|mimes:jpeg,png,jpg,pdf,docx,xls,xlsx|max:2048',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $this->meetingService->createMeeting($request);
        Helper::storeLog("Meeting created successfully", "Meeting", "Create Meeting",$request->lead_id);
        if($request->form_lead_panel==1) {
            return redirect()->back()->with('success', 'Meeting created successfully.');
        }
        return redirect()->route('meeting-index')->with('success', 'Meeting created successfully.');
    }

    // show specified meeting
    public function show($id)
    {
        $meeting = $this->meetingService->getMeetingById($id);
        $lead = null;
        $users = [];

        if ($meeting->lead_id) {
            $lead = Lead::find($meeting->lead_id);
        }

        if ($meeting->recipients) {
            $recipientIds = explode(',', $meeting->recipients); // Assuming recipients are stored as comma-separated IDs
            $users = User::whereIn('id', $recipientIds)->get();
        }
        return view('meetings.show', compact('meeting','lead','users'));
    }

    //form for editing
    public function edit($id)
    {
        $meeting = $this->meetingService->getMeetingById($id);
        // Convert the recipients string into an array
        if ($meeting->recipients) {
            $meeting->recipients = explode(',', $meeting->recipients);
        }

        //$leads = DB::table('leads')->select('id', 'first_name','last_name','email')->get();
        //$users = DB::table('users')->select('id', 'username','email')->get();
        if (Auth::user()->user_type === 'admin') {
            $leads = DB::table('leads')
            ->select('id', 'first_name', 'last_name', 'email')
            ->where('lead_status', 1)
            ->get();
        } else {
            $leads = DB::table('leads')
            ->select('id', 'first_name', 'last_name', 'email')
            ->where('lead_status', 1)
            ->where('created_by', Auth::user()->id)
            ->get();
        }
        $users = DB::table('users')
        ->select('id', 'username', 'email')
        ->where('status', '1')
        ->get();
        return view('meetings.edit', compact('meeting','leads','users'));
    }

    // update the specified meeting
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'meeting_subject' => 'required|string|max:191',
            'meeting_description' => 'nullable|string',
            'meeting_date' => 'required|date',
            'meeting_link' => 'nullable|url',
            'attachments' => 'nullable|file|mimes:jpeg,png,jpg,pdf,docx,xls,xlsx|max:2048',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $this->meetingService->updateMeeting($request, $id);
        Helper::storeLog("Meeting edited successfully", "Meeting", "Edit Meeting",$request->lead_id);
        if($request->form_lead_panel==1) {
            return redirect()->back()->with('success', 'Meeting updated successfully');
        }
        return redirect()->route('meeting-index')->with('success', 'Meeting updated successfully.');
    }

    // remove the specified meeting
    public function destroy($id)
    {   
        $meeting = Meeting::find($id);
        $this->meetingService->deleteMeeting($id);
        Helper::storeLog("Meeting deleted successfully", "Meeting", "delete Meeting",$meeting->lead_id);
        return redirect()->route('meeting-index')->with('success', 'Meeting deleted successfully.');
    }

    // searech for meetings
    public function search(Request $request)
    {
        $searchTerm = trim($request->input('search'));

        if (empty($searchTerm)) {
            return redirect()->route('meeting-index')->with('error', 'Search field cannot be blank.');
        }

        $meetings = $this->meetingService->searchMeetings($request);
        return view('meetings.index', compact('meetings'));
    }



    public function updateAttachmentsFile($id)
    {
        $meeting = Meeting::findOrFail($id);
        if ($meeting->attachments) {
            // path to the image file
            //$imagePath = public_path('uploads/agents/' . $user->profile_image);
            $filePath =getcwd().'/uploads/meetings/'.$meeting->attachments;
            // delete the file if it exists
            if (file_exists($filePath)) {
                unlink($filePath);
            }
            //Update the user record to remove the profile image
            $meeting->attachments = null;
            $meeting->save();
    
            return response()->json(['success' => true]);
        }
    
        return response()->json(['success' => false, 'message' => 'No profile image found']);
    }


    public function updateFeedback(Request $request, $id)
    {
        // Validation
        $request->validate([
            'meeting_feedback' => 'string|max:255',
            'rating' => 'integer|max:5',
        ]);

        // Update the meeting via service
        $result = $this->meetingService->updateFeedback($id, $request->input('meeting_feedback'), $request->input('rating'));

        if ($result) {
            Helper::storeLog("Meeting feedback updated successfully", "Meeting", "updateFeedback", null);
            if($request->form_meeting_feedback==1) {
                return redirect()->back()->with('success', 'Meeting feedback updated successfully.');
            }
            return redirect()->route('meeting-index')->with('success', 'Meeting feedback updated successfully.');
        } else {
            Helper::storeLog("Failed to update the meeting feedback", "Meeting", "updateFeedback", null);
            return back()->withErrors(['error' => 'Failed to update the meeting.']);
        }
    }


    public function getMeetingFeedback($id)
    {
        $meeting = Meeting::find($id);
        if (!$meeting) {
            return response()->json(['error' => 'Meeting not found'], 404);
        }
        //Return the meeting data as a JSON response
        return response()->json([
            'meeting_feedback' => $meeting->meeting_feedback,
            'rating' => $meeting->rating,
        ]);
    }
}

