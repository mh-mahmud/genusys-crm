<?php
namespace App\Http\Controllers;

use App\Helpers\Helper;
use Illuminate\Http\Request;
use App\Services\EmailService;
use App\Models\EmailTemplate;


class EmailController extends Controller {

	// public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    protected $emailService;

    public function __construct(EmailService $emailService)
    {
        $this->emailService = $emailService;
        // $this->middleware('auth');
    }

	public function emailTemplateList(Request $request)
    {      
        $templates = $this->emailService->emailTemplateList($request);
        return view('emails.template-list', compact('templates'));
    }

    public function templateCreate()
    {       
        return view('emails.template-create');
    }

    public function templateStore(Request $request)
    { 
        $result = $this->emailService->templateStore($request);
        if($result->status == 201){
            Helper::storeLog("Email template created successfully", "Email Template", "Create Email Template");
            return redirect()->route('email-template')->with('success', 'Email template created successfully.');

        }else{
            session()->flash('error', 'Can not Create !');
        }

    }

    public function templateShow($id)
    {
        $template = $this->emailService->getEmailTemplateById($id);
        return view('emails.template-show', compact('template'));
    }

    public function templateEdit($id)
    {
        $template = $this->emailService->getEmailTemplateById($id);
        return view('emails.template-edit', compact('template'));
    }

    public function templateDelete($id)
    {
        $this->emailService->templateDelete($id);
        return redirect()->route('email-template')->with('success', 'Email template deleted successfully.');
    }

    public function templateUpdate(Request $request, $id)
    { 
        $result = $this->emailService->templateUpdate($request, $id);
        
        if($result->status == 208){
            Helper::storeLog("Email template edited successfully", "Email Template", "Edit Email Template");
            return redirect()->route('email-template')->with('success', 'Email template updated successfully.');

        }else{
            session()->flash('error', 'Can not Update !');
        }

    }

    public function sendEmail(Request $request)
    {   
        $templates = $this->emailService->getEmailTemplates();
        $leads = Helper::getLeads();
        return view('emails.send-email', compact('templates', 'leads'));
    }

    public function sendEmailPro(Request $request)
    { 
         $result = $this->emailService->sendEmailPro($request);
         if($result->status == 200){
            Helper::storeLog("Email send successfully", "Email Send", "Email Send");
         if($result->status == 200) {
            if($request->form_lead_panel==1) {
                return redirect()->back()->with('success', 'Email send successfully.');
            }
            return redirect()->route('send-email')->with('success', 'Email send successfully.');
        }else{
            session()->flash('error', 'Email can not send !');
        }

    }
  }

    public function sendEmailList(Request $request)
    {      
        $emails = $this->emailService->sendEmailList($request);
        return view('emails.send-email-list', compact('emails'));
    }

    public function sendBulkEmail(Request $request)
    {   
        $templates = $this->emailService->getEmailTemplates();
        return view('emails.send-bulk-email', compact('templates'));
    }

    public function sendBulkEmailPro(Request $request)
    { 
         $result = $this->emailService->sendBulkEmailPro($request);
         if($result->status == 201) {
            Helper::storeLog("Bulk Email send successfully", "Bulk Email Send", "Bulk Email Send");
            return redirect()->route('send-bulk-email')->with('success', 'Email send successfully.');

        } else if ($result->status == 400) {
            return redirect()->route('send-bulk-email')->withErrors(['file' => $result->message]);
        } else{
            session()->flash('error', 'Email can not send !');
        }

    }

    public function getEmailSendById($id)
    {
        $email = $this->emailService->getEmailSendById($id);
        return view('emails.send-email-show', compact('email'));
    }

    public function sendPendingEmail(Request $request)
    {
        $this->emailService->sendPendingEmail($request);

    }

}