<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\SmsService;
use App\Models\smsTemplate;
use App\Helpers\Helper;

class smsController extends Controller {

	// public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    protected $smsService;

    public function __construct(SmsService $smsService)
    {
        $this->smsService = $smsService;
        $this->middleware('auth');
    }

	public function smsTemplateList(Request $request)
    {      
        $templates = $this->smsService->smsTemplateList($request);
        return view('sms.template-list', compact('templates'));
    }

    public function templateCreate()
    {       
        return view('sms.template-create');
    }

    public function templateStore(Request $request)
    { 
        $result = $this->smsService->templateStore($request);
        if($result->status == 201){
            Helper::storeLog("Sms template created successfully", "Sms Template", "Create Sms Template");
        if($result->status == 201) {
            return redirect()->route('sms-template')->with('success', 'Sms template created successfully.');

        }else{
            session()->flash('error', 'Can not Create !');
        }

    }
 }

    public function templateShow($id)
    {
        $template = $this->smsService->getSmsTemplateById($id);
        return view('sms.template-show', compact('template'));
    }

    public function templateEdit($id)
    {
        $template = $this->smsService->getSmsTemplateById($id);
        return view('sms.template-edit', compact('template'));
    }

    public function templateDelete($id)
    {
        $this->smsService->templateDelete($id);
        return redirect()->route('sms-template')->with('success', 'Sms template deleted successfully.');
    }

    public function templateUpdate(Request $request, $id)
    { 
        $result = $this->smsService->templateUpdate($request, $id);
       
        if($result->status == 208){
            Helper::storeLog("Sms template edited successfully", "Sms template", "Edit Sms template");
            return redirect()->route('sms-template')->with('success', 'Sms template updated successfully.');

        }else{
            session()->flash('error', 'Can not Update !');
        }

    }

    public function sendSMSList(Request $request)
    {      
        $sms = $this->smsService->sendSMSList($request);
        return view('sms.send-sms-list', compact('sms'));
    }

    public function sendSms(Request $request)
    {   
        $templates = $this->smsService->getSmsTemplates();
        $leads = Helper::getLeads();
        return view('sms.send-sms', compact('templates', 'leads'));
    }


    public function sendSmsPro(Request $request)
    {
        $result = $this->smsService->sendSmsPro($request);
        if($result->status == 201){
            Helper::storeLog("SMS send successfully", "SMS send", "SMS send");
        if($result->status == 201) {
            if($request->form_lead_panel==1) {
                return redirect()->back()->with('success', 'SMS send successfully.');
            }
            return redirect()->route('send-sms')->with('success', 'SMS send successfully.');

        }else{
            session()->flash('error', 'Can not Send !');
        }
    }
  }

    public function sendBulkSms(Request $request)
    {   
        $templates = $this->smsService->getSmsTemplates();
        return view('sms.send-bulk-sms', compact('templates'));
    }

    
    public function sendBulkSmsPro(Request $request)
    {
        $result = $this->smsService->sendBulkSmsPro($request);
        if($result->status == 201) {
            Helper::storeLog("Bulk SMS send successfully", "Bulk SMS Send", "Bulk SMS Send");
            return redirect()->route('send-bulk-sms')->with('success', 'SMS send successfully.');

        } else if ($result->status == 400) {
            return redirect()->route('send-bulk-sms')->withErrors(['file' => $result->message]);
        } else {
            session()->flash('error', 'Can not Send !');
        }
    }

    public function getSmsSendById($id)
    {
        $sms = $this->smsService->getSmsSendById($id);
        return view('sms.send-sms-show', compact('sms'));
    }

    public function sms_queue_list() {
        return $this->smsService->get_queue_list();
    }

    public function sms_log_list() {
        return $this->smsService->get_log_list();
    }

    public function sms_queue_details($id) {
        return $this->smsService->queue_details($id);
    }
    
    public function sms_log_details($id) {
        return $this->smsService->log_details($id);
    }

    public function single_sms_queue_delete(Request $request, $id) {
        return $this->smsService->single_queue_delete($request, $id);
    }

    public function all_sms_queue_delete(Request $request) {
        return $this->smsService->all_queue_delete($request);
    }
}