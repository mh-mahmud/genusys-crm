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
use App\Models\LeadsForm;
use App\Services\LeadsFormService;

class LeadsFormController extends Controller
{
    protected $leadsFormService;

    public function __construct(LeadsFormService $leadsFormService)
    {
        $this->leadsFormService = $leadsFormService;
        // $this->middleware(['auth']);
    }

    public function index_backup()
    {
        $leadsForms = $this->leadsFormService->getAllLeadsForms();
        $formName = LeadsForm::whereNull('parent_id')->pluck('form_name', 'form_id');
        return view('leads_forms.index', compact('leadsForms', 'formName'));
    }

    public function index()
    {
        $leadsForms = $this->leadsFormService->getAllLeadsForms();
        $formName = LeadsForm::whereNull('parent_id')->pluck('form_name', 'form_id');
        //total lead data count for each form
        $totalLeadsCounts = $this->getTotalLeadsCountsForForms($leadsForms);

        return view('leads_forms.index', compact('leadsForms', 'formName', 'totalLeadsCounts'));
    }




    public function create()
    {
        $parents = LeadsForm::whereNull('parent_id')->pluck('form_name', 'form_id');
        return view('leads_forms.create', compact('parents'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'form_id' => 'nullable|string|max:10',
            'parent_id' => 'nullable|string|max:10',
            'form_name' => 'required|string|max:191',
            'form_description' => 'nullable|string',

        ]);
        //dd($request);die();

        $this->leadsFormService->createLeadsForm($request->all());

        return redirect()->route('leadsform-index')->with('success', 'Leads Form created successfully.');
    }

    public function show($id)
    {
        $leadsForm = $this->leadsFormService->getLeadsFormParentName($id);
        return view('leads_forms.show', compact('leadsForm'));
    }

    public function edit($id)
    {
        $leadsForm = $this->leadsFormService->getLeadsFormById($id);
        $parents = LeadsForm::whereNull('parent_id')->pluck('form_name', 'form_id');
        return view('leads_forms.edit', compact('leadsForm', 'parents'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'form_id' => 'nullable|string|max:10',
            'parent_id' => 'nullable|string|max:10',
            'form_name' => 'required|string|max:191',
            'form_description' => 'nullable|string',
            'form_status' => 'required|integer',
        ]);

        $this->leadsFormService->updateLeadsForm($id, $request->all());

        return redirect()->route('leadsform-index')->with('success', 'Leads Form updated successfully.');
    }

    public function search_backup(Request $request)
    {
        $searchTerm = trim($request->input('search'));
        $formName = LeadsForm::whereNull('parent_id')->pluck('form_name', 'form_id');

        if (empty($searchTerm)) {
            return redirect()->route('leadsform-index')->with('error', 'Search Field cannot be blank.');
        }

        $request->validate([
            'search' => 'required|string',
        ]);

        $leadsForms = $this->leadsFormService->searchLeadForm($request);
        return view('leads_forms.index', compact('leadsForms','formName'));
    }

    public function search(Request $request)
    {
        $searchTerm = trim($request->input('search'));
        $formName = LeadsForm::whereNull('parent_id')->pluck('form_name', 'form_id');


        if (empty($searchTerm)) {
            return redirect()->route('leadsform-index')->with('error', 'Search Field cannot be blank.');
        }

        $request->validate([
            'search' => 'required|string',
        ]);

        $leadsForms = $this->leadsFormService->searchLeadForm($request);
        $totalLeadsCounts = $this->getTotalLeadsCountsForForms($leadsForms);
        return view('leads_forms.index', compact('leadsForms', 'formName', 'totalLeadsCounts'));
    }


    public function destroy($id)
    {
        $this->leadsFormService->deleteLeadsForm($id);
        return redirect()->route('leadsform-index')->with('success', 'Leads Form deleted successfully.');
    }

    private function getTotalLeadsCountsForForms_backup($leadsForms)
    {
        $totalLeadsCounts = [];

        foreach ($leadsForms as $form) {
            $tableNames = explode(',', $form->table_names);
            $totalCount = 0;

            foreach ($tableNames as $tableName) {
                // Chk tableName is not empty before query table data
                if (!empty($tableName)) {
                    $totalCount += DB::table($tableName)->count();
                }
            }

            $totalLeadsCounts[$form->form_id] = $totalCount;
        }

        return $totalLeadsCounts;
    }

    private function getTotalLeadsCountsForForms($leadsForms)
    {
        $totalLeadsCounts = [];

        foreach ($leadsForms as $form) {
            //total number of leads for this form_id
            $leadCount = DB::table('leads')->where('form_id', $form->form_id)->count();
            //store the count in the array with form_id as the key wise
            $totalLeadsCounts[$form->form_id] = $leadCount;
        }

        return $totalLeadsCounts;
    }

}
