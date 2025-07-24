<?php

namespace App\Services;

use App\Models\EmailTemplate;
use App\Models\EmailLog;
use App\Models\Lead;
use App\Models\Logs;
use Exception;
use Mail;
use App\Mail\SingleMail;
use App\Mail\BulkEmail;
use Carbon\Carbon;
use PhpOffice\PhpSpreadsheet\IOFactory;
use DB;
use App\Helpers\Helper;
use App\Models\EmailQueue;
use Illuminate\Support\Facades\Auth;

class EmailService
{
    public function emailTemplateList($request)
    {
        $sql = EmailTemplate::query()
                            ->select('email_templates.*', 'users.first_name', 'users.last_name', 'users.user_type')
                            ->join('users', 'users.id', '=', 'email_templates.created_by');

        $data = $request->all();

        if (Auth::user()->user_type === 'agent') {
            $sql->where(function($query) {
                $query->where('email_templates.created_by', Auth::id()) 
                      ->orWhere('users.user_type', '!=', 'agent');    
            });
        }
        if(!empty($data["search"])) {
            $sql->where('email_subject','like', '%' . $data["search"] . '%');

        }
        if (isset($data['paginate']) && $data['paginate'] == false) {
            return  $sql->where('email_templates.status', 1)->orderBy('email_templates.id', 'DESC')->get();

        } else {
            return  $sql->orderBy('email_templates.id', 'DESC')->paginate(config('constants.ROW_PER_PAGE'));

        }
    }

    public function getEmailTemplates()
    {
        return EmailTemplate::where('status', 1)
                        ->select("id", "email_subject", "email_content")
                        ->get();
    }

    public function templateStore($request)
    {
        $request->validate([
            'email_subject' => 'required',
            'email_content' => 'required',
           
        ]);
        $data = $request->all();

        try {
            return  DB::transaction(function () use ($data) {
                $dataObj                        = new EmailTemplate();
                $dataObj->email_subject         = $data['email_subject'];
                $dataObj->email_content         = $data['email_content'];
                $dataObj->created_by            = Auth::id();
                $dataObj->status                = $data['status'];
                $dataObj->save();
                $log_text = $data['email_subject'].", email template created"; 
                Helper::storeLog($log_text, "Email Template", "Email Template Create", NULL);

                return (object)[
                    'status'                 => 201,
                    'info'                   => $dataObj->id
                ];
        
                
            });


        } catch (Exception $e) {
            return (object)[
                'status'             => 424,
                'error'              => $e->getMessage()
            ];
        }

       
    }

    public function getEmailTemplateById($id)
    {
        return EmailTemplate::findOrFail($id);
    }

    public function templateDelete($id)
    {
        return  DB::transaction(function () use ($id) {
            $data = EmailTemplate::findOrFail($id);
            $data->delete();
            $log_text = $data['email_subject'].", email template deleted"; 

            Helper::storeLog($log_text, "Email Template", "Email Template Delete",  NULL);
        });
    }

    public function templateUpdate($request, $id)
    {
        $request->validate([
            'email_subject' => 'required',
            'email_content' => 'required',
           
        ]);
        $data = $request->all();

        try {
            return  DB::transaction(function () use ($data, $id) {
                $dataObj                        = EmailTemplate::findOrFail($id);
                $dataObj->email_subject         = $data['email_subject'];
                $dataObj->email_content         = $data['email_content'];
                $dataObj->status                = $data['status'];
                $dataObj->updated_by            = Auth::id();
                $dataObj->save();
                $log_text = $data['email_subject'].", email template updated"; 

                Helper::storeLog($log_text, "Email Template", "Email Template Update", NULL);

                return (object)[
                    'status'                 => 208,
                    'info'                   => $dataObj->id
                ];
            });

        } catch (Exception $e) {
            return (object)[
                'status'             => 424,
                'error'              => $e->getMessage()
            ];
        }

    }

    public function sendEmailPro($request) {
        $data = [];
        $request->validate([
            'email_subject' => 'required',
            'email_content' => 'required',
            'to_email'      => 'required|array',
            'to_email.*'    => 'required|email'
        ]);
       
        $data = $request->all();
        // try {
            // Mail::to($to_email)->send(new SingleMail($subject, $body));

            $dataObj                        = new EmailQueue();
            $dataObj->email_from            = "Genuity";
            $dataObj->email_to              = $data['to_email'];
            $dataObj->email_cc              = $data['email_cc'] ?? [];
            $dataObj->email_bcc             = $data['email_bcc'] ?? [];
            $dataObj->email_subject         = $data['email_subject'];
            $dataObj->email_content         = $data['email_content'];
            $dataObj->lead_id               = $data['lead_id'];
            $dataObj->user_id               = Auth::id();
            $dataObj->log_time              = Carbon::now();
            $dataObj->send_status           = config('constants.campaign_status')["Pending"];
            $dataObj->save();
            
        // } catch (Exception $e) {
        //     return (object)[
        //         'status'                 => 401,
        //         'message'                => $e->getMessage()
        //     ];

        // }

        return (object)[
            'status'                 => 200,
            'message'                => "Email sent successfully"
        ];

    }

    public function sendEmailList($request)
    {
        $logs = EmailLog::with(
                    'lead:id,first_name,last_name',
                    'user:id,first_name,last_name'
                )
                ->when(
                    $request->filled('search'),
                    fn ($q) => $q->where('email_to', 'like', '%'.$request->input('search').'%')
                )
                ->orderByDesc('id')
                ->paginate(config('constants.ROW_PER_PAGE'));
        return $logs;
    }

    public function  sendBulkEmailPro($request)
    {
        $request->validate([
            'file' => 'required|file',
            'email_subject' => 'required|string|max:150',
            'email_content' => 'required|string',
        ]);
        $allowedExtensions = ['csv', 'xls', 'xlsx'];
        if (!in_array($request->file('file')->getClientOriginalExtension(), $allowedExtensions)) {
            return (object)[
                'status' => 400,
                'message' => 'The file must be a type of: csv, xlsx, xls.'
            ];
        }
        
        $file = $request->file('file');
        $data = $request->all();
        $emailLogs = [];
        // try {
            // Check if the file is an Excel file
            if ($file->getClientOriginalExtension() == 'csv') {
                // Process CSV file
                $rows = array_map('str_getcsv', file($file));
            } else {
                // Process Excel file using PhpSpreadsheet
                $spreadsheet = IOFactory::load($file->getPathname());
                $worksheet = $spreadsheet->getActiveSheet();
                $rows = $worksheet->toArray();
            }


            foreach ($rows as $key => $row) {
                if ($key == 0) {
                    continue;
                }

                if (!isset($row[0]) || empty($row[0])) {
                    continue;
                }
        
                // Mail::to($row[0])->queue(new BulkEmail($data['email_subject'], $data['email_content']));
                $emails     = preg_split('/[\s,]+/', $row[0] ?? '', -1, PREG_SPLIT_NO_EMPTY);
                $emailCC    = preg_split('/[\s,]+/', $row[1] ?? '', -1, PREG_SPLIT_NO_EMPTY);
                $emailBCC   = preg_split('/[\s,]+/', $row[2] ?? '', -1, PREG_SPLIT_NO_EMPTY);

                $lead = Lead::where('email', $row[0])
                              ->select('id')
                              ->first();
                $emailLogs[] = [
                    'email_from'    => "Genuity",
                    'email_to'      => json_encode($emails),
                    'email_cc'      => json_encode($emailCC ?: []),
                    'email_bcc'     => json_encode($emailBCC ?: []),
                    'lead_id'       => $lead->id ?? null,
                    'email_subject' => $data['email_subject'],
                    'email_content' => $data['email_content'],
                    'log_time'      => Carbon::now(),
                    'user_id'       => Auth::id(),
                    'send_status'   => config('constants.campaign_status')["Pending"]
                ];
            }

            return  DB::transaction(function () use ($emailLogs) {
                EmailQueue::insert($emailLogs);
                return (object)[
                    'status'                 => 201,
                ];
            });

        // } catch (\Exception $e) {
        //     return (object)[
        //         'status'                 => 401,
        //         'message'                => $e->getMessage()
        //     ];
        // }
        return (object)[
            'status'                 => 201,
        ];
    }

    public function getEmailSendById($id)
    {
        return EmailLog::with(
                            'lead:id,first_name,last_name',
                            'user:id,first_name,last_name'
                        )->where('email_log.id', $id) 
                        ->first();
    }

    public function sendPendingEmail($request) 
    {
        $pending_emails = EmailQueue::with('user:id,first_name,last_name,email')
                                    ->where('send_status', config('constants.campaign_status')["Pending"])
                                    ->orderBy('id', 'asc')
                                    ->limit(15)
                                    ->get();

        DB::transaction(function () use ($pending_emails) {
            foreach($pending_emails as $email) {
                $senderName = $senderEmail = '';
                try {
                    if($email->user) {
                        $senderName = $email->user->first_name.' '.$email->user->last_name;
                        $senderEmail = $email->user->email;
                    }
                   
                    Mail::to($email->email_to ?? [])
                        ->cc($email->email_cc ?? [])
                        ->bcc($email->email_bcc ?? [])
                        ->send(new SingleMail($email->email_subject, $email->email_content));				
                    // Mail::to($email->email_to ?? [])
                    //     ->cc($email->email_cc ?? [])
                    //     ->bcc($email->email_bcc ?? [])
                    //     ->send((new SingleMail($email->email_subject, $email->email_content))
                    //     ->from($senderEmail, $senderName));
                    $this->logEmail($email, "Success");
                    Helper::storeLog("Email sent successfully to " . implode(', ', $email->email_to), "Email Module", "Send an Email", $email->lead_id, $email->user_id);
                    EmailQueue::where('id', $email->id)->delete();

                } catch (\Exception $e) {
                    $this->logEmail($email, "Failed");
                    Helper::storeLog("Email failed to send to " . $email->email_to, "Email Module", "Send an Email", $email->lead_id, $email->user_id);
                    EmailQueue::where('id', $email->id)->delete();

                }
            }
        });
    }

    private function logEmail($email, $status)
    {
        $dataObj = new EmailLog();
        $dataObj->email_from = isset($email->user) ? $email->user->first_name.' '.$email->user->last_name : '';
        $dataObj->email_to = $email->email_to;
         $dataObj->email_cc = $email->email_cc;
        $dataObj->email_bcc  = $email->email_bcc;
        $dataObj->email_subject = $email->email_subject;
        $dataObj->email_content = $email->email_content;
        $dataObj->lead_id = $email->lead_id;
        $dataObj->meeting_id = $email->meeting_id;
        $dataObj->campaign_id = $email->campaign_id;
        $dataObj->csv_id = $email->csv_id;
        $dataObj->user_id = $email->user_id;
        $dataObj->log_time = Carbon::now();
        $dataObj->delivery_time = Carbon::now();
        $dataObj->send_status = config('constants.campaign_status')[$status];
        $dataObj->save();
    }

}