<?php

namespace App\Services;

use App\Models\SmsTemplate;
use App\Models\SmsLog;
use App\Models\Logs;
use App\Models\SmsQueue;
use Exception;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use DB;
use PhpOffice\PhpSpreadsheet\IOFactory;
use App\Helpers\Helper;
use App\Models\Lead;


class SmsService
{
    public function smsTemplateList($request)
    {
        $sql = SmsTemplate::query()
                        ->select('sms_templates.*', 'users.first_name', 'users.last_name', 'users.user_type')
                        ->join('users', 'users.id', '=', 'sms_templates.created_by');
        $data = $request->all();

        if (Auth::user()->user_type === 'agent') {
            $sql->where(function($query) {
                $query->where('sms_templates.created_by', Auth::id()) 
                      ->orWhere('users.user_type', '!=', 'agent');    
            });
        }
        if(!empty($data["search"])) {
            $sql->where('title','like', '%' . $data["search"] . '%');

        }
       
        if (isset($data['paginate']) && $data['paginate'] == false) {
            return  $sql->where('sms_templates.status', 1)->orderBy('id', 'DESC')->get();

        } else {
            return  $sql->orderBy('id', 'DESC')->paginate(config('constants.ROW_PER_PAGE'));

        }
    }

    public function getSmsTemplates()
    {
        return SmsTemplate::where('status', 1)
                        ->select('sms_templates.id', 'sms_templates.title', 'description')
                        ->get();
    }


    public function templateStore($request)
    {
        $request->validate([
            'title' => 'required|unique:sms_templates|max:100',
            'description' => 'required|max:191',
           
        ]);
        $data = $request->all();

        try {
            return  DB::transaction(function () use ($data) {
                $dataObj                        = new SmsTemplate();
                $dataObj->title                 = $data['title'];
                $dataObj->description           = $data['description'];
                $dataObj->created_by            = Auth::id();
                $dataObj->status                = $data['status'];
                $dataObj->save();
                $log_text = $data['title'].", SMS template created"; 

                Helper::storeLog($log_text, "SMS Template", "SMS Template Create", NULL);

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

    public function getSmsTemplateById($id)
    {
        return SmsTemplate::findOrFail($id);
    }

    public function templateDelete($id)
    {
        return  DB::transaction(function () use ($id) {
            $data = SmsTemplate::findOrFail($id);
            $data->delete();
            $log_text = $data['title'].", SMS template deleted"; 

            Helper::storeLog($log_text, "SMS Template", "SMS Template Delete", NULL);
        });
    }

    public function templateUpdate($request, $id)
    {
        $request->validate([
            'title' => 'required|unique:sms_templates,title,'.$id,
            'description' => 'required|max:191',
           
        ]);
        $data = $request->all();

        try {
            return  DB::transaction(function () use ($data, $id) {
                $dataObj                        = SmsTemplate::findOrFail($id);
                $dataObj->title                 = $data['title'];
                $dataObj->description           = $data['description'];
                $dataObj->updated_by            = Auth::id();
                $dataObj->status                = $data['status'];
                $dataObj->save();
                $log_text = $data['title'].", SMS template updated"; 

                Helper::storeLog($log_text, "SMS Template", "SMS Template Update", NULL);

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

    public function sendSmsPro($request) {

        $data = [];
        $request->validate([
            'sms_to' => ['required', 'digits:11'],
            'sms_text' => 'required|max:191'
        ],[
            'sms_to.required' => 'Mobile NO is required',
            'sms_to.digits' => 'Mobile NO have to be 11 digits',
            'sms_text.required' => 'Content is required',
            'sms_text.max' => 'Content may not be greater than 191 characters',
        ]);


        $api_response = Helper::send_sms($request->sms_to, $request->sms_text);
        $data = $request->all();
        $dataObj                        = new SmsLog();
        $dataObj->sms_from              = config('constants.SMS_SEND_MOBILE_NO');
        $dataObj->lead_id               = $data['lead_id'];
        $dataObj->api_response               = $api_response;
        $dataObj->sms_to                = $data['sms_to'];
        $dataObj->sms_text              = $data['sms_text'];
        $dataObj->log_time              = Carbon::now();
        $dataObj->user_id               = Auth::id();

        try {
            $dataObj->send_status       = 1;
            $dataObj->save();
            Helper::storeLog("SMS send successfully to " .$data['sms_to'], "SMS Module", "Send SMS", $data['lead_id']);
        } catch (\Exception $e) {
            $dataObj->send_status       = 0;
            $dataObj->save();
            Helper::storeLog("SMS send fail to " .$data['sms_to'], "SMS Module", "Send SMS",  $data['lead_id']);

            return (object)[
                'status'                 => 401,
                'message'                => $e->getMessage()
            ];

        }
        return (object)[
            'status'                 => 201,
            'info'                   => $dataObj->id
        ];
	}

    public function sendSMSList($request)
    {
        $sql = SmsQueue::query()
                    ->select('sms_queue.*', 'leads.first_name', 'leads.last_name', 'users.first_name as send_by_fname', 'users.last_name as send_by_lname')
                    ->leftJoin('leads', 'sms_queue.lead_id', '=', 'leads.id')
                    ->join('users', 'users.id', '=', 'sms_queue.user_id');
        $data = $request->all();
        if(!empty($data["search"])) {
            $sql->where('sms_to','like', '%' . $data["search"] . '%');

        }
        return $sql->orderBy('id', 'DESC')->paginate(config('constants.ROW_PER_PAGE'));
    }

    public function  sendBulkSmsPro($request)
    {
        $request->validate([
            'file' => 'required|file',
            'sms_text' => 'required|string|max:180'
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

        try {
            if ($file->getClientOriginalExtension() == 'csv') {
                $rows = array_map('str_getcsv', file($file));
            } else {
                $spreadsheet = IOFactory::load($file->getPathname());
                $worksheet = $spreadsheet->getActiveSheet();
                $rows = $worksheet->toArray();
            }

            DB::beginTransaction();

            foreach ($rows as $key => $row) {
                if ($key == 0) {
                    continue;
                }

                if (!isset($row[0]) || empty($row[0])) {
                    continue;
                }

                $mobile_no = "0".$row[0];
                $lead = Lead::where('phone', $mobile_no)
                              ->select('id')
                              ->first();
                $smsLogs[] = [
                    'sms_from'      => config('constants.SMS_SEND_MOBILE_NO'),
                    'sms_to'        => $mobile_no,
                    'lead_id'       => $lead->id ?? null,
                    'sms_text'      => $data['sms_text'],
                    'user_id'       => Auth::id(),
                    'log_time'      => Carbon::now(),
                    'send_status'   => 1
                ];

                $logs[] = [
                    'log_message'   => "SMS send successfully to " .$mobile_no." => SMS Module  => Send Bulk SMS",
                    'module'        => "SMS Module",
                    'sub_module'    => "Send Bulk SMS",
                    'user_id'       => Auth::id(),
                    'lead_id'       => $lead->id ?? null,
                    'status'        => 1,
                    'created_at'    => Carbon::now()
                    ];


            }
            SmsQueue::insert($smsLogs);
            Logs::insert($logs);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return (object)[
                'status'                 => 401,
                'message'                => $e->getMessage()
            ];
        }

        return (object)[
            'status'                 => 201,
        ];
    }

    public function getSmsSendById($id)
    {
        return SmsQueue::where('sms_queue.id', $id)
                        ->select('sms_queue.*', 'leads.first_name', 'leads.last_name', 'users.first_name as send_by_fname', 'users.last_name as send_by_lname')
                        ->leftJoin('leads', 'sms_queue.lead_id', '=', 'leads.id')
                        ->join('users', 'users.id', '=', 'sms_queue.user_id')
                        ->first();
    }
   
    public function get_queue_list() {
		return SmsQueue::paginate(20);
	}

	public function get_log_list() {
		return SmsLog::paginate(20);
	}

	public function queue_details($id) {
        $data = [];
        $chk_data = SmsQueue::find($id);

        if(!empty($chk_data)) {
            $data[] = ['status' => 'success', 'msg' => 'data found', 'data' => $chk_data];
            return response()->json(compact('data'))->setStatusCode(200);
        }
        $data[] = ['status' => 'failed', 'msg' => 'no data found'];
        return response()->json(compact('data'))->setStatusCode(401);
	}

	public function log_details($id) {
        $data = [];
        $chk_data = SmsLog::find($id);

        if(!empty($chk_data)) {
            $data[] = ['status' => 'success', 'msg' => 'data found', 'data' => $chk_data];
            return response()->json(compact('data'))->setStatusCode(200);
        }
        $data[] = ['status' => 'failed', 'msg' => 'no data found'];
        return response()->json(compact('data'))->setStatusCode(401);
	}

    public function single_queue_delete($request, $id)
    {
        $data = [];
        $request->validate([
            'delete_code' => 'required'
        ]);

        $check = SmsQueue::find($id);
        if(!empty($check)) {
            $data['data'] = SmsQueue::destroy($id);
            $data['status'] = "success";
            $data['msg'] = ["Single Queue deleted successfully"];
            return response()->json(compact('data'))->setStatusCode(200);
        }
        $data['status'] = "failed";
        $data['msg']= ["no data found"];
        return response()->json(compact('data'))->setStatusCode(401);
    }

    public function all_queue_delete($request)
    {
        $data = [];
        $request->validate([
            'delete_code' => 'required'
        ]);

        $deleted = SmsQueue::truncate();
        if(!empty($deleted)) {
        	$data['data'] = $deleted;
            $data['status'] = "success";
            $data['msg'] = ["All Queue deleted successfully"];
            return response()->json(compact('data'))->setStatusCode(200);
        }
        $data['status'] = "failed";
        $data['msg']= ["no data found"];
        return response()->json(compact('data'))->setStatusCode(401);
    }

}