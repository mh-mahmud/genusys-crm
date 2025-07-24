<?php
namespace App\Services\API;
use App\Models\SmsTemplate;
use App\Models\SmsQueue;
use App\Models\SmsLog;

class SmsService {

	public function get_all_templates() {
		return SmsTemplate::paginate(2);
	}

	public function sms_template_destroy_service() {
        $data = [];
        $request->validate([
            'id' => 'required'
        ]);

        $check = SmsTemplate::find($request->id);
        if(!empty($check)) {
            $data['data'] = SmsTemplate::destroy($request->id);
            $data['status'] = "success";
            $data['msg'] = ["SmsTemplate deleted successfully"];
            return response()->json(compact('data'))->setStatusCode(200);
        }
        $data['status'] = "failed";
        $data['msg']= ["no data found"];
        return response()->json(compact('data'))->setStatusCode(401);
	}

	public function send_sms_service($request) {
        $data = [];
        $request->validate([
            'user_id' => 'required',
            'sms_from' => 'required',
            'sms_to' => 'required',
            'sms_text' => 'required'
        ]);

        if(empty($request->send_status)) {
            $request['send_status'] = 0;
        }

        if(empty($request->priority_level)) {
            $request['priority_level'] = 5;
        }
        $request['log_time'] = date("Y-m-d h:i:s", time());

        try {
            $data['data'] = SmsQueue::create($request->all());
            $data['status'] = "success";
            $data['msg']=["Sms sending is on process successfully"];
            return response()->json(compact('data'))->setStatusCode(200);

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['error' => 'User not found'], 404);
        } catch (\Exception $e) {
            // Handle other types of exceptions
            return response()->json(['error' => $e->getMessage()], 500);
        }
	}

	public function sms_template_update_service() {
        $data = [];
        $request->validate([
            'id' => 'required'
        ]);

        $branch_data = SmsTemplate::find($request->id);
        if(!empty($branch_data)) {
            $branch_data->update($request->all());
            $data['status'] = "success";
            $data['msg']=["SmsTemplate updated successfully"];
            $data['data'] = $branch_data;
            return response()->json(compact('data'))->setStatusCode(200);
        }

        $data['status'] = "failed";
        $data['msg']=["no data found"];
        return response()->json(compact('data'))->setStatusCode(401);
	}

	public function sms_template_show_service($id) {
        $data = [];
        $chk_data = SmsTemplate::find($id);
        if(!empty($chk_data)) {
            $status = "success";
            $msg=["data found"];
            $data['data'] = $chk_data;
            return response()->json(compact('data'))->setStatusCode(200);
        }
        $data['status'] = "failed";
        $data['msg']=["no data found"];
        return response()->json(compact('data'))->setStatusCode(401);
	}

	public function sms_template_create_service($request) {
        $data = [];
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'status' => 'required'
        ]);

        $ckh_dub = SmsTemplate::where('title', $request->title)->first();
        if(!empty($ckh_dub)) {
            $data['status'] = "dublicate";
            $data['msg']=["this template already created"];
            return response()->json(compact('data'))->setStatusCode(200);
        }

        $data['data'] = SmsTemplate::create($request->all());
        $data['status'] = "success";
        $data['msg']=["SmsTemplate saved successfully"];
        return response()->json(compact('data'))->setStatusCode(200);
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