<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\Campaign;
use Illuminate\Support\Facades\Response;
use App\Services\CampaignService;
use App\Models\Promotion;
use App\Models\LeadsForm;
use App\Models\EmailTemplate;
use App\Models\SmsTemplate;
use App\Models\CampaignData;
use App\Models\EmailQueue;
use App\Models\SmsQueue;
use App\Mail\BulkEmail;
use Mail;
use App\Helpers\Helper;

class CampaignController extends Controller
{
    protected $campaignService;

    public function __construct(CampaignService $campaignService)
    {
        $this->campaignService = $campaignService;
    }

    public function index()
    {
        $campaigns = $this->campaignService->getAllCampaign();
        //dd($campaigns);die();
        return view('campaigns.index', compact('campaigns'));
    }

    public function create()
    {
        $promotions = Promotion::pluck('promotion_title', 'id');
        $formName = LeadsForm::pluck('form_name', 'form_id');
        //$email = EmailTemplate::pluck('email_subject', 'id');
       // $sms = SmsTemplate::pluck('title', 'id');
        $email = EmailTemplate::where('status', 1)->pluck('email_subject', 'id');
        $sms = SmsTemplate::where('status', 1)->pluck('title', 'id');
        return view('campaigns.create', compact('promotions', 'formName', 'email', 'sms'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'campaign_title' => 'required',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
        ]);

        $this->campaignService->createCampaign($request->all());
        Helper::storeLog("Campaign created successfully", "Campaign", "Create Campaign");

        return redirect()->route('campaign-index')->with('success', 'Campaign created successfully.');
    }

    public function show($id)
    {
        $campaign = $this->campaignService->getCampaignDetailsID($id);
        return view('campaigns.show', compact('campaign'));
    }

    public function edit($id)
    {
        $campaign = $this->campaignService->getCampaignById($id);
        $promotions = Promotion::pluck('promotion_title', 'id');
        $formName = LeadsForm::pluck('form_name', 'form_id');
        //$email = EmailTemplate::pluck('email_subject', 'id');
        //$sms = SmsTemplate::pluck('title', 'id');
        $email = EmailTemplate::where('status', 1)->pluck('email_subject', 'id');
        $sms = SmsTemplate::where('status', 1)->pluck('title', 'id');
        return view('campaigns.edit', compact('campaign', 'promotions', 'formName', 'email', 'sms'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'campaign_title' => 'required',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
        ]);

        $data = $request->all();
        //dd($data);die();
        $this->campaignService->updateCampaign($id, $data);
        Helper::storeLog("Campaign updated successfully", "Campaign", "Edit Campaign");
        return redirect()->route('campaign-index')->with('success', 'Campaign updated successfully.');
    }

    public function search(Request $request)
    {
        $searchTerm = trim($request->input('search'));

        if (empty($searchTerm)) {
            return redirect()->route('campaign-index')->with('error', 'Search Field cannot be blank.');
        }

        $request->validate([
            'search' => 'required|string',
        ]);

        $campaigns = $this->campaignService->searchCampaign($request);
        return view('campaigns.index', compact('campaigns'));
    }


    public function destroy($id)
    {
        $this->campaignService->deleteCampaign($id);
        Helper::storeLog("Campaign deleted successfully", "Campaign", "Delete Campaign");
        return redirect()->route('campaign-index')->with('success', 'Campaign deleted successfully.');
    }
    


    public function clearSession(Request $request)
    {
        $request->session()->forget('success');
        $request->session()->forget('error');
        return response()->json(['status' => 'Session cleared']);
    }


    public function campaign_leads_upload($id)
    {
        //dd($id);die();
        $campaign = $this->campaignService->getCampaignDetailsID($id);
        return view('campaigns.campaign_leads_upload', compact('campaign'));
    }

    public function downloadCampaignSampleFile(Request $request)
    {
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="campaign_sample_file.csv"',
        ];

        $callback = function () use ($request) {
            $handle = fopen('php://output', 'w');

            if ($request->template_type == 'Email') {
                fputcsv($handle, ['Email']);
            } elseif ($request->template_type == 'SMS') {
                fputcsv($handle, ['Phone']);
            } else {
                //fputcsv($handle, ['Email', 'Phone']);
            }

            fclose($handle);
        };

        return Response::stream($callback, 200, $headers);
    }


    public function campaign_lead_upload_file(Request $request)
    {
        $result = $this->campaignService->campaign_lead_upload_file($request);

        if (isset($result['error'])) {
            return redirect()->back()->with('error', $result['error'])->withInput();
        }
        Helper::storeLog("Campaign data uploaded successfully", "Campaign Data", "Upload Campaign");
        return redirect()->back()->with('success', $result['success']);
    }


    public function campaign_data($id)
    {
        $campaign_data = $this->campaignService->getAllCampaignData($id);
        //dd($campaigns);die();
        return view('campaigns.campaign_data', compact('campaign_data'));
    }



    public function startCampaign($id)
    {
        try {
            $result = $this->campaignService->startCampaign($id);
            return redirect()->route('campaign-index')->with('success', $result);
        } catch (\Exception $e) {
            return redirect()->route('campaign-index')->with('error', $e->getMessage());
        }
    }



    public function stopCampaign($id)
    {
        try {
            $result = $this->campaignService->stopCampaign($id);
            return redirect()->route('campaign-index')->with('success', $result);
        } catch (\Exception $e) {
            return redirect()->route('campaign-index')->with('error', $e->getMessage());
        }
    }





}
