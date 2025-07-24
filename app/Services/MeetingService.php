<?php

namespace App\Services;

use App\Models\Meeting;
use Illuminate\Support\Facades\Storage;
use App\Models\EmailQueue;
use App\Models\Lead;
use App\Models\User;
use Carbon\Carbon;
use App\Models\SmsQueue;
use Illuminate\Support\Facades\Auth;
use App\Models\Notification;

class MeetingService
{
    
    public function getAllMeetings()
    {
        //return Meeting::where('created_by', Auth::user()->id)->orderBy('created_at', 'desc')->paginate(config('constants.ROW_PER_PAGE'));
        if (Auth::user()->user_type !== 'admin') {
            return Meeting::where('created_by', Auth::user()->id)->orderBy('created_at', 'desc')->paginate(config('constants.ROW_PER_PAGE'));
            
        } else {
            return Meeting::orderBy('created_at', 'desc')->paginate(config('constants.ROW_PER_PAGE'));
          
        }
    }

    
    public function createMeeting($request)
    {
        $fileNameToStore = null;

        if ($request->hasFile('attachments')) {
            $file = $request->file('attachments');
            $fileNameToStore = time().'_'.$file->getClientOriginalName();
            $file->move(getcwd().'/uploads/meetings', $fileNameToStore);
        }
        $recipients = is_array($request->recipients) ? implode(',', $request->recipients) : null;
        $meeting =Meeting::create([
            'lead_id' => $request->lead_id,
            'recipients' => $recipients,
            'created_by' => auth()->id(),
            'meeting_subject' => $request->meeting_subject,
            'meeting_description' => $request->meeting_description,
            'meeting_date' => $request->meeting_date,
            'meeting_link' => $request->meeting_link,
            'attachments' => $fileNameToStore,
            'duration' => $request->duration,
            'status' => $request->status,
            'send_email' => isset($request->send_email) ? 1 : 0,
            'send_sms' => isset($request->send_sms) ? 1 : 0,
            
        ]);
        $meetingId = $meeting->id;


        //insert notification
        // $notification = Notification::create([
        //     'lead_id' => $request->lead_id,
        //     'user_id' => auth()->id(),
        //     'notify_msg' => 'New meeting scheduled: ' . $request->meeting_subject,
        //     'notify_datetime' => $request->meeting_date,
        //     'send_email' => isset($request->send_email) ? 1 : 0,
        //     'send_sms' => isset($request->send_sms) ? 1 : 0,
        //     'notify_seen' => 0,
        // ]);
        //if send_email is checked,insert email data into the EmailQueue table
        if (isset($request->send_email) && $request->send_email == 1) {
            $this->queueEmails($request,$meetingId);
        }

        //if send_sms is checked, insert SMS data into the SmsQueue table
        if (isset($request->send_sms) && $request->send_sms == 1) {
            $this->queueSMS($request,$meetingId);
        }
    }


    protected function queueEmails($request,$meetingId)
    {
        
        $recipients = is_array($request->recipients) ? $request->recipients : [];
        //initialize an array to store all email addresses to avoid duplicate insertions
        $allRecipients = [];
        //chk if lead_id is set and fetch email from the Lead table
        if (isset($request->lead_id)) {
            $lead = Lead::find($request->lead_id);
             //if a lead is found and has an email, add it to the allRecipients array
            if ($lead && $lead->email) {
                $allRecipients[] = [
                    'email' => $lead->email,
                 
                ];
            }
        }
         //chk if recipients are provided, fetch their emails from the User table
        if (!empty($recipients)) {
            $users = User::whereIn('id', $recipients)->get();
    
            foreach ($users as $user) {
                if ($user->email) {
                    $allRecipients[] = [
                        'email' => $user->email,
                       
                    ];
                }
            }
        }
        foreach ($allRecipients as $recipient) {
            EmailQueue::create([
                'email_from' => 'Genuity',
                'meeting_id' =>$meetingId,
                'email_to' => $recipient['email'],
                'email_subject' => $request->meeting_subject,
                'email_content' => $request->meeting_description . ' Meeting Link: ' . $request->meeting_link,
                'log_time' => Carbon::now(),
                'user_id' => auth()->id(),
                'send_status' => config('constants.meeting_status.Pending'),
            ]);
        }
    }
    

    protected function queueSMS($request, $meetingId)
    {  
        $recipients = is_array($request->recipients) ? $request->recipients : [];
        //initialize an array to store all phone numbers to avoid duplicate insertions
        $allRecipients = [];
        //chk if lead_id is set and fetch phone number from the Lead table
        if (isset($request->lead_id)) {
            $lead = Lead::find($request->lead_id);
            //if a lead is found and has a phone number, add it to the allRecipients array
            if ($lead && $lead->phone) {
                $allRecipients[] = [
                    'phone_number' => $lead->phone,
                ];
            }
        }
        //chk if recipients are provided, fetch their phone numbers from the User table
        if (!empty($recipients)) {
            $users = User::whereIn('id', $recipients)->get();
    
            foreach ($users as $user) {
                if ($user->phone_number) {
                    $allRecipients[] = [
                        'phone_number' => $user->phone_number,
                    ];
                }
            }
        }
       foreach ($allRecipients as $recipient) {
            SmsQueue::create([
                'sms_from' => 'Genuity', 
                'meeting_id' => $meetingId,
                'sms_to' => $recipient['phone_number'],
                'sms_text' => $request->meeting_description . ' Meeting Link: ' . $request->meeting_link,
                'log_time' => Carbon::now(),
                'user_id' => auth()->id(),
                'send_status' => config('constants.meeting_status.Pending'),
            ]);
        }
    }
    

    
    public function getMeetingById($id)
    {
        return Meeting::findOrFail($id);
    }

    
    public function updateMeeting($request, $id)
    {
        $meeting = Meeting::findOrFail($id);
        //handle file attachment
        if ($request->hasFile('attachments')) {
            // chk if there's an existing file and delete it
            if ($meeting->attachments) {
                $existingFilePath = getcwd() . '/uploads/meetings/' . $meeting->attachments;
                if (file_exists($existingFilePath)) {
                    unlink($existingFilePath);
                }
            }
    
            //upload new attachment
            $file = $request->file('attachments');
            $fileNameToStore = time() . '_' . $file->getClientOriginalName();
            $file->move(getcwd() . '/uploads/meetings', $fileNameToStore);
            $meeting->attachments = $fileNameToStore;
        }
        //handle recipients
        $recipients = is_array($request->recipients) ? implode(',', $request->recipients) : null;
        //update the meeting details
        $meeting->update([
            'lead_id' => isset($request->lead_id) ? $request->lead_id : null,
            'recipients' => isset($recipients) ? $recipients : null,
            'meeting_subject' => $request->meeting_subject,
            'meeting_description' => $request->meeting_description,
            'meeting_date' => $request->meeting_date,
            'meeting_link' => $request->meeting_link,
            'attachments' => $meeting->attachments,
            'duration' => $request->duration,
            'status' => $request->status,
            'send_email' => isset($request->send_email) ? 1 : 0,
            'send_sms' => isset($request->send_sms) ? 1 : 0,
        ]);
    
        
        if (isset($request->send_email) && $request->send_email == 1) {
            EmailQueue::where('meeting_id', $meeting->id)->delete();
            //insert new email records
            $this->queueEmails($request, $meeting->id);
        }
        if (isset($request->send_sms) && $request->send_sms == 1) {
            SmsQueue::where('meeting_id', $meeting->id)->delete();
            $this->queueSMS($request, $meeting->id); 
        }
    }
    


   
    public function deleteMeeting($id)
    {
        $meeting = Meeting::findOrFail($id);

        if ($meeting->attachments) {
            //$existingFilePath = public_path('uploads/meetings/'.$meeting->attachments);
            $existingFilePath = getcwd() . '/uploads/meetings/' . $meeting->attachments;
            if (file_exists($existingFilePath)) {
                unlink($existingFilePath);
            }
        }
        //delete the EmailQueue and SmsQueue records associated with this meeting
        EmailQueue::where('meeting_id', $meeting->id)->delete();
        SmsQueue::where('meeting_id', $meeting->id)->delete();
        $meeting->delete();
    }

    
    public function searchMeetings($request)
    {
        $searchTerm = trim($request->input('search'));

        return Meeting::where('meeting_subject', 'LIKE', "%{$searchTerm}%")
            ->orWhere('meeting_description', 'LIKE', "%{$searchTerm}%")
            ->orWhere('meeting_date', 'LIKE', "%{$searchTerm}%")
            ->orderBy('created_at', 'desc')
            ->paginate(config('constants.ROW_PER_PAGE'));
    }


    public function updateFeedback($id, $meeting_feedback, $rating)
    {
        // find the meeting by ID
        $meeting = Meeting::find($id);
        
        if (!$meeting) {
            return false;
        }

        // update feedback and rating
        $meeting->meeting_feedback = $meeting_feedback;
        $meeting->rating = $rating;

        return $meeting->save();
    }
}
