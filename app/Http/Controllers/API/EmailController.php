<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Services\API\EmailService;
use App\Models\EmailTemplate;
use Mail;
use App\Mail\SingleMail;

class EmailController extends Controller
{
    protected $service;
    public function __construct(EmailService $email_service) {
    	$this->service = $email_service;
    }

    /*
        Email Templates
    */
        
    public function email_template_list()
    {
        return EmailTemplate::all();
    }

    public function email_template_create(Request $request)
    {
        $data = [];
        $request->validate([
            'email_subject' => 'required',
            'email_content' => 'required'
        ]);

        $ckh_dub = EmailTemplate::where('email_subject', $request->email_subject)->first();
        if(!empty($ckh_dub)) {
            $data['status'] = "dublicate";
            $data['msg']=["this template already created"];
            return response()->json(compact('data'))->setStatusCode(200);
        }

        $data['data'] = EmailTemplate::create($request->all());
        $data['status'] = "success";
        $data['msg']=["EmailTemplate saved successfully"];
        return response()->json(compact('data'))->setStatusCode(200);
    }

    public function email_template_show(string $id)
    {
        $data = [];
        $chk_data = EmailTemplate::find($id);
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

    public function email_template_update(Request $request)
    {
        $data = [];
        $request->validate([
            'id' => 'required'
        ]);

        $branch_data = EmailTemplate::find($request->id);
        if(!empty($branch_data)) {
            $branch_data->update($request->all());
            $data['status'] = "success";
            $data['msg']=["EmailTemplate updated successfully"];
            $data['data'] = $branch_data;
            return response()->json(compact('data'))->setStatusCode(200);
        }

        $data['status'] = "failed";
        $data['msg']=["no data found"];
        return response()->json(compact('data'))->setStatusCode(401);
    }

    public function email_template_destroy(Request $request)
    {
        $data = [];
        $request->validate([
            'id' => 'required'
        ]);

        $check = EmailTemplate::find($request->id);
        if(!empty($check)) {
            $data['data'] = EmailTemplate::destroy($request->id);
            $data['status'] = "success";
            $data['msg'] = ["EmailTemplate deleted successfully"];
            return response()->json(compact('data'))->setStatusCode(200);
        }
        $data['status'] = "failed";
        $data['msg']= ["no data found"];
        return response()->json(compact('data'))->setStatusCode(401);
    }

    public function send_email(Request $request) {
        $data = [];
        $request->validate([
            'subject' => 'required',
            'body' => 'required',
            'to_email' => 'required'
        ]);

        $subject = $request->subject;
        $body = $request->body;
        $to_email = $request->to_email;

        
        try {
            Mail::to($to_email)->send(new SingleMail($subject, $body));
            $data['status'] = "success";
            $data['message'] = "Email sent successfully";
            return response()->json(compact('data'))->setStatusCode(200);
        } catch (Exception $e) {
            $data['status'] = "failed";
            $data['message'] = $e->getMessage();
            return response()->json(compact('data'))->setStatusCode(401);
        }

    }
}
