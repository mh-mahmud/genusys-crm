<?php
namespace App\Http\Controllers;
use App\Services\ProposalService;
use App\Services\CountryService;
use App\Services\CurrencyService;
use App\Helpers\Helper;
use App\Models\Proposal;
use App\Models\Country;
use App\Models\Currency;

use Illuminate\Http\Request;


class ProposalController extends Controller {
    protected $proposalService;
    protected $countryService;
    protected $currencyService;

    public function __construct(ProposalService $proposalService, CountryService $countryService, CurrencyService $currencyService)
    {
        $this->proposalService = $proposalService;
        $this->countryService  = $countryService;
        $this->currencyService  = $currencyService;

        $this->middleware('auth');
    }

    public function proposalList(Request $request)
    {      
        $proposals = $this->proposalService->proposalList($request);
        return view('proposals.proposal-list', compact('proposals'));
    }

    public function addProposal(Request $request)
    {      
        $countries = Country::where('status', 1)->get();
        $currencies = Currency::where('status', 1)->get();
        $leads = $this->proposalService->getLeadsData();

        return view('proposals.add-proposal', compact('countries', 'currencies', 'leads'));
    }

    public function saveProposal(Request $request) {

        $request->validate([
            'subject' => 'required|string|max:191',
            'lead_id' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
            'currency' => 'required',
            'status' => 'required',
            'send_to' => 'required|email',
            'price' => 'required|numeric',
            'offer_price' => 'required|numeric',
            'item_name' => 'required|string|max:191',
            'item_description' => 'required|string',
            'upload_file' => 'file|mimes:xlsx,xls,pdf,docx,txt|max:1024',
        ]);

        $entry = $this->proposalService->save_proposal($request);
        Helper::storeLog("proposal sent successfully", "proposal", "save proposal", null, $request->lead_id);
        return redirect()->route('proposal-list')->with('success', 'Proposal created successfully.');
    }

    public function show($id) {
        $data = $this->proposalService->proposal_details($id);
        return view('proposals.show', compact('data'));
    }

    public function edit(Request $request, $id) {
        $countries = $this->countryService->countryList($request);
        $currencies = $this->currencyService->currencyList($request);
        $leads = $this->proposalService->getLeadsData();
        $data = $this->proposalService->proposal_details($id);
        return view('proposals.edit', compact('data', 'countries', 'currencies', 'leads'));
    }

    public function update(Request $request, $id) {
        $request->validate([
            'subject' => 'required|string|max:191',
            'lead_id' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
            'currency' => 'required',
            'status' => 'required',
            'send_to' => 'required|email',
            'price' => 'required|numeric',
            'offer_price' => 'required|numeric',
            'item_name' => 'required|string|max:191',
            'item_description' => 'required|string',
            'upload_file' => 'file|mimes:xlsx,xls,pdf,docx,txt|max:1024',
        ]);

        $entry = $this->proposalService->update_proposal($request, $id);
        Helper::storeLog("proposal edited", "proposal", "edit proposal", null, $request->lead_id);
        return redirect()->back()->with('success', 'Proposal updated successfully.');
    }

    public function delete_proposal($id) {
        $proposal = Proposal::findOrFail($id);
        $leadId = $proposal->lead_id;
        $this->proposalService->delete_proposal($id);
        Helper::storeLog("proposal deleted successfully", "proposal", "delete proposal", null,$leadId);
        return redirect()->back()->with('success', 'Proposal deleted successfully.');
    }
    

}