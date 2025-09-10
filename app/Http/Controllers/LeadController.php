<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\LeadsForm;
use App\Models\Customer;
use App\Models\LeadFormDetail;
use App\Models\Lead;
use App\Models\EmailLog;
use App\Models\SmsQueue;
use App\Models\Meeting;
use App\Models\Proposal;
use App\Models\Logs;
use App\Models\Invoice;
use App\Models\ProductSpecification;
use App\Models\ScheduleCall;
use App\Services\LeadService;
use App\Services\UserService;
use App\Services\EmailService;
use App\Services\SmsService;
use Illuminate\Support\Facades\Schema;
use DateTime;
use App\Models\Product;
use App\Helpers\Helper;

use App\Models\VehicleInformation;
use App\Models\VehicleAttributes;
use App\Models\GeneralInformation;
use App\Models\QuoteDetails;
use App\Models\DriverAttributes;
use App\Models\DriverInformation;
use App\Models\RateAnalysisData;
use App\Models\ResultCode;
use App\Models\ResultAction;
use App\Models\LeadResultCode;
use App\Models\LeadStatus;
use App\Models\LeadCycle;
use App\Http\Controllers\CustomerController;

class LeadController  extends Controller
{
    protected $leadService;
    protected $emailService;
    protected $smsService;
    protected $user_service;
    protected $cs_controller;

    public function __construct(LeadService  $leadService, EmailService $emailService, SmsService $smsService, UserService $user_service, CustomerController $cs_controller)
    {
        $this->leadService = $leadService;
        $this->user_service = $user_service;
        $this->emailService = $emailService;
        $this->smsService = $smsService;
        $this->cs_controller = $cs_controller;
    }


    public function index_backup()
    {
        $leads = $this->leadService->getAllLeads();
        //$formName = LeadsForm::pluck('form_name', 'form_id');
        $formName = LeadsForm::whereNull('parent_id')->pluck('form_name', 'form_id');
        return view('leads.index', compact('leads', 'formName'));
    }

    public function index($form_id = null)
    {
        // get all leads or filter by form_id if provided
        if ($form_id) {
            $leads = $this->leadService->getLeadsByFormId($form_id);
        } else {
            $leads = $this->leadService->getAllLeads();
        }

        // get form names where parent_id is null
        $formName = LeadsForm::whereNull('parent_id')->pluck('form_name', 'form_id');

        return view('leads.index', compact('leads', 'formName'));
    }

    public function total_lead()
    {
    
  
    $leads = $this->leadService->getTotalLeads();
    $formName = LeadsForm::whereNull('parent_id')->pluck('form_name', 'form_id');

    return view('leads.index', compact('leads','formName'));
    }

    public function create_backup()
    {

        return view('leads.create');
    }

    public function create(Request $request)
    {
        //dd('sdsd');die();
        $formName = [
            1 => 'Form A',
            2 => 'Form B',

        ];

        $fieldsByTable = [];
        $old_phone = null;
        if(!empty($_GET['phone'])) {
            $old_phone = $_GET['phone'];
        }

        if ($request->has('form_id')) {
            $formId = $request->input('form_id');
            $fields = LeadFormDetail::where('form_id', $formId)->orderBy('form_serial')->orderBy('id')->get();

            foreach ($fields as $field) {
                $fieldsByTable[$field->table_name][] = $field;
            }
        }
        $users = User::where('user_type', 'user')->where('status', 1)->get(['id', 'user_id', 'first_name', 'last_name', 'email', 'phone_number']);
        $lead_result_codes = ResultCode::select('id', 'code', 'title')->get();
        $status_list = LeadStatus::where('status', 1)->get(['status_name']);

        return view('leads.create', compact('formName', 'fieldsByTable', 'old_phone', 'users', 'lead_result_codes', 'status_list'));
    }

    public function save_lead_note(Request $request) {
        $request->validate([
            //'lead_notes' => 'required|string|max:191',
            'result_codes_id' => 'required'
        ]);

        try {
            // insert into lead_reasult_code
            $res_code = new LeadResultCode();
            $res_code->lead_id = $request->lead_id;
            $res_code->result_codes_id = $request->result_codes_id;
            $res_code->lead_notes = $request->lead_notes;
            $res_code->created_by = Auth::user()->id;
            $res_code->save();

            # check rule in action => result_action
            
            $res_code = ResultCode::where('id', $request->result_codes_id)->first();
            $res_action = ResultAction::where('id', $res_code->result_action_id)->first();
            $user_list = User::where('user_type', '!=', 'admin')->pluck('id')->toArray();

            if($res_code->code=="SOLD") {
                try{
                    $lead = Lead::findOrFail($request->lead_id);
                    $leadData = $lead;
                    $lead->lead_status = "Sold";
                    $lead->lead_rating = 10;
                    $lead->update();
                    

                    ########## Add as customer ##########
                    $customer_id = $this->cs_controller->generateRandomString();
                    $data = new Customer();
                    $data->lead_id = $request->lead_id;
                    $data->customer_id = $customer_id;
                    $data->first_name = $leadData->first_name;
                    $data->last_name = $leadData->last_name;
                    $data->phone = $leadData->phone;
                    $data->email = $leadData->email;
                    $data->product_id = null;
                    $data->customer_listing_date = date("Y-m-d h:i:s");
                    if($data->save()) {
                        Helper::storeLog("Listed as a Customer ", "Customers", "Create Customer", $request->lead_id);
                    }
                    return redirect()->back()->with('success', 'Status changed successfully and listed as customer');
                } catch(\Exception $e) {
                    return redirect()->back()->with('error', $e->getMessage());
                }
            }

            if($res_action->rule_type=="Dead") {

                // remove from lead list and sent to archive
                $cycle = LeadCycle::where('lead_id', $request->lead_id)->where('status', 1)->get();
                if(!$cycle->isEmpty()) {
                        try{
                            DB::select("UPDATE lead_cycle SET status='4' WHERE lead_id='{$request->lead_id}' AND status='1'");
                            $lead = Lead::findOrFail($request->lead_id);
                            $lead->lead_status = "Dead";
                            $lead->update();
                        } catch(\Exception $e) {
                            return redirect()->back()->with('error', $e->getMessage());
                        }

                }
                return redirect()->back()->with('success', 'Status changed successfully.');
            }
            else if($res_action->rule_type=="PARK" || $res_action->rule_type=="General") {

                for($i=0; $i<3; $i++) {
                    shuffle($user_list);
                    try {
                        $cycle = new LeadCycle();
                        if($i==0) {
                            $cycle->priority = $res_action->distribution_priority;
                            $cycle->cycle_time = date("Y-m-d H:i:s", time() + ($res_action->distribution_time*60));
                        }

                        if($i==1) {
                            $cycle->priority = $res_action->after_1st_park_priority;
                            $cycle->cycle_time = date("Y-m-d H:i:s", time() + ($res_action->after_1st_park_time*60));
                        }

                        if($i==2) {
                            $cycle->priority = $res_action->after_2nd_park_priority;
                            $cycle->cycle_time = date("Y-m-d H:i:s", time() + ($res_action->after_2nd_park_time*60));
                        }

                        
                        $cycle->lead_id = $request->lead_id;
                        $cycle->user_id = $user_list[0];
                        $cycle->no_of_attempt = $res_action->num_attempts;
                        $cycle->feedback = $res_action->rule_description;
                        $cycle->save();
                        // dd($cycle);
                    } catch (\Exception $e) {
                        // return back()->withErrors(['error' => $e->getMessage()]);
                        return back()->withErrors(['error' => $e->getMessage()]);
                        dd($e->getMessage());
                    }

                }
            }
            else if($res_action->rule_type=="Callback") {
                // add data to schedule callback data
                try {
                    $lead_data = Lead::where('id', $request->lead_id)->first();
                    $schedule = new ScheduleCall();
                    $schedule->lead_id = $request->lead_id;
                    $schedule->schedule_time = $request->schedule_time;
                    $schedule->user_id = Auth::user()->id;
                    $schedule->phone_number = $lead_data->phone;
                    $schedule->home_phone = $lead_data->home_phone;
                    $schedule->work_phone = $lead_data->work_phone;
                    $schedule->save();
                    return redirect()->back()->with('success', 'A schedule call added successfully.');
                } catch(\Exception $e) {
                    return redirect()->back()->with('error', $e->getMessage());
                }
            }
            return redirect()->back()->with('success', 'Note created successfully.');

        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Error occurred while retrieving data.']);
        }
    }

    public function save_assign_lead(Request $request) {
        $request->validate([
            'assigned_to' => 'required'
        ]);

        try {
            // update lead table
            $res_code = Lead::findOrFail($request->lead_id);
            $res_code->assigned_to = $request->assigned_to;
            $res_code->updated_by = Auth::user()->id;
            $res_code->updated_at = date("Y-m-d H:i:s");
            $res_code->save();
            Helper::storeLog("Lead assigned successfully", "Lead", "Assign Lead",$res_code->id);
            return redirect()->back()->with('success', 'Lead assigned successfully.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Error occurred while retrieving data.']);
        }
    }

    public function store(Request $request)
    {

        $request->validate([
            'first_name' => 'required|string|max:191',
            'last_name' => 'required|string|max:191',
            'email' => 'nullable|string|email|max:191|unique:leads,email',
            'phone' => 'required|string|max:191',
            //'form_id' => 'required|exists:leads_form,form_id',
            'profile_image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        //dd($request);die();

        //$data = $request->only(['first_name', 'last_name', 'title', 'email', 'phone', 'lead_status','form_id']);
        $data = $request->all();

        $dynamicFields = $request->except(['first_name', 'last_name', 'title', 'email', 'phone', 'form_id', '_token']);
        //dd($dynamicFields);die();



        $lead =$this->leadService->createLead($data, $request->input('form_id'), $dynamicFields, $request);
        Helper::storeLog("Lead created successfully", "Lead", "Create Lead",$lead->id);

        return redirect()->route('lead-index')->with('success', 'Lead created successfully.');
    }


    public function quickLeadStore(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|max:191',
            'last_name' => 'required|string|max:191',
            'email' => 'nullable|string|email|max:191|unique:leads,email',
            'phone' => 'required|string|max:191',
            //'form_id' => 'required|exists:leads_form,form_id',
            'profile_image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
    
        //check validation fails
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        //$data = $request->only(['first_name', 'last_name', 'title', 'email', 'phone', 'lead_status','form_id']);
        $data = $request->all();

        $dynamicFields = $request->except(['first_name', 'last_name', 'title', 'email', 'phone', 'form_id', '_token']);
        //dd($dynamicFields);die();



        $lead =$this->leadService->createLead($data, $request->input('form_id'), $dynamicFields, $request);
        Helper::storeLog("Lead created successfully", "Lead", "Create Lead",$lead->id);

        return redirect()->route('dashboard')->with('success', 'Lead created successfully.');
    }

    public function show($id)
    {

        $menus = $this->user_service->menu_list();
        $menu_access = [];
        foreach($menus as $key=>$val) {
            $menu_access[] = strtolower($key);
        }
        // dd($menu_access);

        $lead = $this->leadService->getLeadById($id);
        $lead_result_codes = ResultCode::where('selectable', 'Yes')->get(['id', 'code', 'title']);
        $lead_result_codes_note = ResultCode::where('selectable', 'Yes')
        ->with('resultAction')
        ->get(['id', 'code', 'title', 'result_action_id']);
        //dd($lead_result_codes);
        $lead_data_id = $id;
        $is_customer = Customer::where('lead_id', $id)->first();
        $customer_id = null;
        if(!empty($is_customer)) {
            $customer_id = $is_customer->customer_id;
        }

        //dynamic fields data based on lead_id
        $fields = LeadFormDetail::where('form_id', $lead->form_id)->orderBy('table_name')->get();
        $tableData = [];
        foreach ($fields as $field) {
            $tableName = $field->table_name;
            $tableData[$tableName] = DB::table($tableName)->where('lead_id', $lead->id)->orderBy('id', 'desc')->get();
        }

        $emails = [];
        if(in_array("email_module", $menu_access)) {
            $emails = EmailLog::where('lead_id', $id)->get();
        }

        $sms = [];
        if(in_array("sms_module", $menu_access)) {
            $sms = SmsQueue::where('lead_id', $id)->get();
        }

        $meetings = [];
        if(in_array("meeting", $menu_access)) {
            $meetings = Meeting::where('lead_id', $id)->get();
        }

        $proposals = [];
        if(in_array("proposal", $menu_access)) {
            $proposals = Proposal::where('lead_id', $id)->get();
        }
        
        $rate_api_data = [];
        $api_data = RateAnalysisData::where('lead_id', $id)->first();
        if(!empty($api_data)) {
            $rate_api_data = json_decode($api_data->rate_analysis_data);
        }
        
        
        //$logs = Logs::where('lead_id', $id)->get();
        //$logs = Logs::where('lead_id', $id)->orderBy('created_at', 'desc')->get();
        $logs = Logs::join('users', 'logs.user_id', '=', 'users.id')
        ->where('logs.lead_id', $id)
        ->select('logs.*', 'users.first_name', 'users.last_name')
        ->orderBy('logs.created_at', 'desc')
        ->get();
        $invoices = Invoice::join('customers', 'invoices.customer_id', '=', 'customers.id')
            ->join('leads', 'customers.lead_id', '=', 'leads.id')
            ->select('invoices.*', 'customers.customer_group', 'leads.first_name', 'leads.last_name')
            ->where('lead_id', $id)
            ->where('invoices.approval_status', 'approved')
            ->orderBy('invoices.created_at', 'desc')->get();
        $productSpecifications = ProductSpecification::join('customers', 'product_specification.customer_id', '=', 'customers.id')
        ->join('leads', 'customers.lead_id', '=', 'leads.id')
        ->select('product_specification.*','customers.customer_group','leads.first_name','leads.last_name')
        ->where('lead_id', $id)
        ->orderBy('product_specification.created_at', 'desc')->get();
        foreach ($productSpecifications as $specification) {
            $productIds = $specification->product_id ? explode(',', $specification->product_id) : [];//comma-separated string to array,
            $specification->product_ids = $productIds;
            $productNames = Product::whereIn('id', $productIds)->pluck('name')->toArray();
            $specification->product_names = implode(', ', $productNames);
        }
        $totalWorkOrderNumber = ProductSpecification::join('customers', 'product_specification.customer_id', '=', 'customers.id')
        ->where('customers.lead_id', $id)
        ->whereNotNull('product_specification.work_order_number')
        ->where('product_specification.work_order_number', '<>', '')
        //->distinct('product_specification.work_order_number')
        ->count('product_specification.work_order_number');

        $totalWorkOrderValue = ProductSpecification::join('customers', 'product_specification.customer_id', '=', 'customers.id')
        ->where('customers.lead_id', $id)
        ->sum('product_specification.work_order_value');

        $totalAmcEffectiveAmount = ProductSpecification::join('customers', 'product_specification.customer_id', '=', 'customers.id')
        ->where('customers.lead_id', $id)
        ->sum('product_specification.amc_effective_amount');

        $totalAmcRate = ProductSpecification::join('customers', 'product_specification.customer_id', '=', 'customers.id')
        ->where('customers.lead_id', $id)
        ->avg('product_specification.amc_rate');
        $invoicesGroupedByPsId = Invoice::join('customers', 'invoices.customer_id', '=', 'customers.id')
        ->join('leads', 'customers.lead_id', '=', 'leads.id')
        ->select(
            'invoices.*',
            'customers.customer_group',
            'leads.first_name',
            'leads.last_name'
        )
        ->orderBy('invoices.created_at', 'desc')
        ->get()
        ->groupBy('ps_id');

        $templates = $this->emailService->getEmailTemplates();
        $sms_templates = $this->smsService->getSmsTemplates();
        
        $products = Product::where('status', 1)->get();
        $customers = Customer::where('customers.lead_id', '=', $id)->join('leads', 'customers.lead_id', '=', 'leads.id')
        ->select('customers.*', 'leads.first_name', 'leads.last_name')
        ->get();
        $lead_customer = Customer::where('customers.lead_id', '=', $id)->join('leads', 'customers.lead_id', '=', 'leads.id')
        ->select('customers.*', 'leads.first_name', 'leads.last_name')
        ->first();
        $latestMeeting = Meeting::where('lead_id', $id)->orderBy('created_at', 'desc')->first();
        $notelogs = LeadResultCode::with('lead_res_code')->where('lead_id', $id)->get();
        $users = User::where('user_type', 'user')->where('status', 1)->get(['id', 'user_id', 'first_name', 'last_name', 'email', 'phone_number']);
        // dd($notelogs[0]->lead_res_code->title);

        // dd($lead->created_name->first_name);
        return view('leads.show', compact('lead', 'tableData','fields', 'customer_id', 'emails', 'sms', 'meetings', 'proposals', 'logs', 'invoices', 'productSpecifications','totalWorkOrderNumber','totalWorkOrderValue','totalAmcEffectiveAmount','totalAmcRate','invoicesGroupedByPsId', 'templates', 'sms_templates', 'products', 'customers','lead_data_id','lead_customer','latestMeeting', 'menu_access', 'rate_api_data', 'lead_result_codes', 'notelogs', 'users', 'lead_result_codes_note'));
    }



    public function add_14082025($tableName, $leadId)
    {
        $columns = [];
        $columnDetails = [];
        $fields = collect(); 
        $tablesMap = [
            'driver_information'  => ['driver_information', 'driver_attributes'],
            'vehicle_information' => ['vehicle_information', 'vehicle_attributes']
        ];

        $tablesToFetch = $tablesMap[$tableName] ?? [$tableName];

        foreach ($tablesToFetch as $table) {
            $table = trim($table); 
            if (Schema::hasTable($table)) {
                $columns = array_merge($columns, Schema::getColumnListing($table));
                $columnDetails = array_merge($columnDetails, DB::select("SHOW COLUMNS FROM `$table`"));
                 $fields = $fields->merge(
                    LeadFormDetail::where('table_name', $table)->get()
                );
            }
        }

        //column names
        // $columns = Schema::getColumnListing($tableName);
        // fetch lead form details
        // $fields = LeadFormDetail::where('table_name', $tableName)->get();
        //fetch lead details associated with the lead ID
        $leads = Lead::where('id', $leadId)->first();
        //fetch column details with data types using raw SQL query
        // $columnDetails = DB::select("SHOW COLUMNS FROM $tableName");

        //map column names to their types
        $columnTypes = [];
        $dropdownOptions = [];
        foreach ($columnDetails as $column) {
            $columnName = $column->Field;
            $columnType = $column->Type;
            // chk if the field_value in $fields is 'file' and override the type
            foreach ($fields as $field) {
                if ($field->field_value == 'file' && $columnName == $field->field_name) {
                    $columnType = 'file';
                    break;
                }elseif ($field->field_value == 'dropdown' && $columnName == $field->field_name) {
                    $columnType = 'dropdown';
                     // split the character length field into an array if it is a dropdown list
                    if (!empty($field->character_length)) {
                        $dropdownOptions[$columnName] = explode(',', $field->character_length);
                    }
                    break;
                }
            }
            $columnTypes[$columnName] = $columnType;
        }

        // filter out unwanted fields
        $filteredColumns = array_filter($columns, function ($column) {
            return !in_array($column, ['id', 'created_at', 'updated_at']);
        });

        // return view with necessary data
        return view('leads.add', compact('tableName', 'filteredColumns', 'leads', 'columnTypes', 'dropdownOptions'));
    }


    public function add($tableName, $leadId)
{
    $tablesMap = [
        'driver_information'  => ['driver_information', 'driver_attributes'],
        'vehicle_information' => ['vehicle_information', 'vehicle_attributes']
    ];

    $tablesToFetch = $tablesMap[$tableName] ?? [$tableName];

    $tableData = []; // store columns,types,options grouped by table

    foreach ($tablesToFetch as $table) {
        $table = trim($table);

        if (Schema::hasTable($table)) {
            $columns = Schema::getColumnListing($table);
            $columnDetails = DB::select("SHOW COLUMNS FROM `$table`");
            $fields = LeadFormDetail::where('table_name', $table)->get();

            $columnTypes = [];
            $dropdownOptions = [];

            foreach ($columnDetails as $column) {
                $columnName = $column->Field;
                $columnType = $column->Type;

                foreach ($fields as $field) {
                    if ($field->field_value == 'file' && $columnName == $field->field_name) {
                        $columnType = 'file';
                        break;
                    } elseif ($field->field_value == 'dropdown' && $columnName == $field->field_name) {
                        $columnType = 'dropdown';
                        if (!empty($field->character_length)) {
                            $dropdownOptions[$columnName] = explode(',', $field->character_length);
                        }
                        break;
                    }
                }

                $columnTypes[$columnName] = $columnType;
            }

            // remove unwanted fields
            $filteredColumns = array_filter($columns, function ($col) {
                return !in_array($col, ['id', 'created_at', 'updated_at', 'driver_info_id', 'vehicle_info_id']);
            });

            $tableData[$table] = [
                'columns'         => $filteredColumns,
                'types'           => $columnTypes,
                'dropdownOptions' => $dropdownOptions
            ];
        }
    }

    $leads = Lead::where('id', $leadId)->first();

    return view('leads.add', compact('tableName', 'tableData', 'leads'));
}


    public function storeTableData_14082025(Request $request)
    {
        $tableName = $request->input('tableName');
        $data = $request->except(['_token', 'tableName']);
        $lead_id = $request->input('lead_id');
        $form_id = $request->input('form_id');
        $data['lead_id'] = $lead_id;
        $data['form_id'] = $form_id;
        $fields = LeadFormDetail::where('table_name', $tableName)->get();
        foreach ($fields as $field) {
            $columnName = $field->field_name;
            // chk if the field is a file input
            if ($field->field_value === 'file' && $request->hasFile($columnName)) {
                $fileNameWithExt = $request->file($columnName)->getClientOriginalName();
                $fileName = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
                $extension = $request->file($columnName)->getClientOriginalExtension();
                $fileNameToStore = $fileName . '_' . time() . '.' . $extension;
                $request->file($columnName)->move(getcwd() . '/uploads/files', $fileNameToStore);
                $data[$columnName] = $fileNameToStore;
            }
        }
        if (Schema::hasColumns($tableName, ['created_by','created_at', 'updated_at'])) {
            $data['created_by'] = Auth::user()->username;
            $data['created_at'] = now();
            $data['updated_at'] = now();
           
        }
        DB::table($tableName)->insert($data);
        Helper::storeLog("Lead $tableName table data created successfully", "Lead", "Create Lead Table Data",$lead_id);
        return redirect()->route('lead-show', ['id' => $lead_id])->with('success', 'Data inserted successfully');
    }

    public function storeTableData(Request $request)
    {
        $tableName = $request->input('tableName');
        $lead_id   = $request->input('lead_id');
        $form_id   = $request->input('form_id');

        //mapping main table to related tables
        $tablesMap = [
            'driver_information'  => ['driver_information', 'driver_attributes'],
            'vehicle_information' => ['vehicle_information', 'vehicle_attributes']
        ];

        // get list of tables to insert into
        $tablesToInsert = $tablesMap[$tableName] ?? [$tableName];

        foreach ($tablesToInsert as $table) {
            //only this table input data
            $tableInputs = $request->input($table, []);

            //add common fields
            $tableInputs['lead_id'] = $lead_id;
            $tableInputs['form_id'] = $form_id;
            
            $fields = LeadFormDetail::where('table_name', $table)->get();
            foreach ($fields as $field) {
                $columnName = $field->field_name;

                if ($field->field_value === 'file' && $request->hasFile($table . '.' . $columnName)) {
                    $uploadedFile = $request->file($table . '.' . $columnName);
                    $fileNameWithExt = $uploadedFile->getClientOriginalName();
                    $fileName = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
                    $extension = $uploadedFile->getClientOriginalExtension();
                    $fileNameToStore = $fileName . '_' . time() . '.' . $extension;

                    $uploadedFile->move(getcwd() . '/uploads/files', $fileNameToStore);
                    $tableInputs[$columnName] = $fileNameToStore;
                }
            }

            // add creator
            if (Schema::hasColumns($table, ['created_by','created_at', 'updated_at'])) {
                $tableInputs['created_by'] = Auth::user()->username;
                $tableInputs['created_at'] = now();
                $tableInputs['updated_at'] = now();
            }

            //insert
            DB::table($table)->insert($tableInputs);

            Helper::storeLog(
                "Lead $table table data created successfully",
                "Lead",
                "Create Lead Table Data",
                $lead_id
            );
        }

        return redirect()
            ->route('lead-show', ['id' => $lead_id])
            ->with('success', 'Data inserted successfully');
   }



    public function deleteTableData($tableName, $id, $leadId)
    {
        $this->leadService->deleteTableRecord($tableName, $id, $leadId);
        //return redirect()->route('lead-index')->with('success', 'Record deleted successfully.');
        Helper::storeLog("Lead $tableName table data Deleted successfully", "Lead", "Delete Lead Table Data",$leadId);
        return redirect()->route('lead-show', ['id' => $leadId])->with('success', 'Data Deleted successfully');
    }


    public function edit_backup($id)
    {
        //$formName = LeadsForm::pluck('form_name', 'form_id');
        $formName = LeadsForm::whereNull('parent_id')->pluck('form_name', 'form_id');
        $lead = $this->leadService->getLeadById($id);
        $fieldsByTable = [];
        $tableData = [];

        if ($lead->form_id) {
            $formId = $lead->form_id;
            $fields = LeadFormDetail::where('form_id', $formId)->get();

            foreach ($fields as $field) {
                $fieldsByTable[$field->table_name][] = $field;

                // specific table based on lead_id
                if (!isset($tableData[$field->table_name])) {
                    $tableData[$field->table_name] = DB::table($field->table_name)->where('lead_id', $lead->id)->first();
                }
            }
        }

        return view('leads.edit', compact('lead', 'formName', 'fieldsByTable', 'tableData'));
    }

    public function edit($id)
    {
        //$formName = LeadsForm::pluck('form_name', 'form_id');
        $formName = LeadsForm::whereNull('parent_id')->pluck('form_name', 'form_id');
        $lead = $this->leadService->getLeadById($id);
        $tableData = [];

        //dynamic fields data based on lead_id
        $fields = LeadFormDetail::where('form_id', $lead->form_id)->orderBy('table_name')->get();
        $tableData = [];
        foreach ($fields as $field) {
            $tableName = $field->table_name;
            $tableData[$tableName] = DB::table($tableName)->where('lead_id', $lead->id)->get();
        }
        $status_list = LeadStatus::where('status', 1)->get(['status_name']);


        return view('leads.edit', compact('lead', 'formName', 'tableData', 'status_list'));
    }




    public function update(Request $request, $id)
    {
        $request->validate([
            'first_name' => 'required|string|max:191',
            'last_name' => 'required|string|max:191',
            'email' => 'nullable|string|email|max:191|unique:leads,email,' . $id,
            'phone' => 'required|string|max:191',
            //'form_id' => 'required|exists:leads_form,form_id',
            'profile_image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->all();
        $this->leadService->updateLead($id, $data, $request);
        Helper::storeLog("Lead updated successfully", "Lead", "Edit Lead",$id);

        return redirect()->route('lead-index')->with('success', 'Lead updated successfully.');
    }


    public function search(Request $request)
    {
        $searchTerm = trim($request->input('search'));
        $formName = LeadsForm::pluck('form_name', 'form_id');

        if (empty($searchTerm)) {
            return redirect()->route('lead-index')->with('error', 'Search Field cannot be blank.');
        }

        $request->validate([
            'search' => 'required|string',
        ]);

        $leads = $this->leadService->searchLeadForm($request);
        return view('leads.index', compact('leads', 'formName'));
    }

    public function destroy($id)
    {
        $this->leadService->deleteLead($id);
        Helper::storeLog("Lead deleted successfully", "Lead", "Delete Lead",$id);
        return redirect()->route('lead-index')->with('success', 'Lead deleted successfully.');
    }


    public function editTableData($tableName, $leadId)
    {
        try {
            //dd($leadId);die();
            $data = $this->leadService->getTableData($tableName, $leadId);
            $previousUrl = url()->previous();
            $lastFourDigits = substr($previousUrl, -4);
            //dd($lastSixDigits);die();
            return view('leads.edit_table_data', $data, array_merge($data, ['lastFourDigits' => $lastFourDigits]));
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Error occurred while retrieving data.']);
        }
    }

    public function ShowTableDataDetails($tableName, $leadId)
    {
        try {
            //dd($leadId);die();
            $data = $this->leadService->getTableDataDetails($tableName, $leadId);
            $previousUrl = url()->previous();
            $lastFourDigits = substr($previousUrl, -4);
            //dd($lastSixDigits);die();
            //return view('leads.show_table_details', $data, array_merge($data, ['lastFourDigits' => $lastFourDigits]));
            return view('leads.show_table_details_modal', $data, array_merge($data, ['lastFourDigits' => $lastFourDigits]));
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Error occurred while retrieving data.']);
        }
    }

 
    public function updateTableData(Request $request)
    {
        $tableName = $request->input('tableName');
        $leadId = $request->input('lead_id');
        $formId = $request->input('form_id');
        $leadTableId = $request->input('lead_table_id');
        $lastFourDigits = $request->input('last_four_digit');
        $formData = $request->except(['_token', 'tableName', 'lead_id', 'form_id', 'lead_table_id','last_four_digit']);
     
        try {
            DB::beginTransaction();
    
            // Call service method to update the data
            $this->leadService->updateTableData($request, $tableName, $leadId, $formId, $formData);
    
            DB::commit();

            //return redirect()->route('lead-edit', ['id' => $leadTableId])->with('success', 'Data updated successfully');
            // Conditional redirection based on the value of $lastFourDigits
            if ($lastFourDigits === 'edit') {
                Helper::storeLog("Lead $tableName table data updated successfully", "Lead", "Edit Lead Table Data",$leadTableId);
                return redirect()->route('lead-edit', ['id' => $leadTableId])->with('success', 'Data updated successfully');
            } else {
                Helper::storeLog("Lead $tableName table data updated successfully", "Lead", "Edit Lead Table Data",$leadTableId);
                return redirect()->route('lead-show', ['id' => $leadTableId])->with('success', 'Data Edited successfully');
            }
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => '' . $e->getMessage()]);
        }
    }
    

    public function leads_upload_backup(Request $request)
    {
        //dd($request->form_id);die();
        $formName = [
            1 => 'Form A',
            2 => 'Form B',

        ];

        $fieldsByTable = [];
        $formId = $request->input('form_id');

        if ($request->has('form_id')) {
            $formId = $request->input('form_id');
            $fields = LeadFormDetail::where('form_id', $formId)->get();

            foreach ($fields as $field) {
                $fieldsByTable[$field->table_name][] = $field;
            }
        }

        return view('leads.leads_upload', compact('formName', 'fieldsByTable', 'formId'));
    }


    public function leads_upload(Request $request)
    {
        $formId = $request->input('form_id');
        return view('leads.leads_upload', compact('formId'));
    }

    public function leads_json_upload(Request $request)
    {
        $formId = $request->input('form_id');
        return view('leads.leads_json_upload', compact('formId'));
    }


    public function downloadSampleFile_backup(Request $request)
    {
        // Validate the request
        $request->validate([
            'form_id' => 'required|exists:leads_form,form_id'
        ]);
        $leadFormDetailsColumns = LeadFormDetail::where('form_id', $request->form_id)->pluck('field_name')->toArray();
        // get columns from Lead table
        $leadColumns = (new Lead)->getFillable();

        //merge columns ensuring no duplicates
        $columns = array_unique(array_merge($leadColumns, $leadFormDetailsColumns));
        $columns = array_filter($columns, function ($column) {
            return $column !== 'form_id' && $column !== 'parent_id';
        });

        //dd($columns);die();
        $callback = function () use ($columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);
            fclose($file);
        };

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="sample-file.csv"',
        ];

        return Response::stream($callback, 200, $headers);
    }


    public function downloadSampleFile(Request $request)
    {
        // Validate the request
        $request->validate([
            'form_id' => 'required|exists:leads_form,form_id'
        ]);
        //$leadFormDetailsColumns = LeadFormDetail::where('form_id', $request->form_id)->pluck('field_name')->toArray();
        $leadFormDetailsColumns = LeadFormDetail::where('form_id', $request->form_id)
        ->where('field_value', '!=', 'file') // Exclude fields with 'file'
        ->pluck('field_name')
        ->toArray();
        // Get columns from Lead table
        //$leadColumns = (new Lead)->getFillable();
        $lead = new Lead;
        //$leadColumns = array_diff($lead->getFillable(), ['lead_status', 'no_of_employee',]);
        $leadColumns = array_diff($lead->getFillable(), ['lead_status', 'no_of_employee','title','profile_image','gender','dob','marital_status','lead_source','age','created_by']);

        //merge columns ensuring no duplicates
        $columns = array_unique(array_merge($leadColumns, $leadFormDetailsColumns));
        $columns = array_filter($columns, function ($column) {
            return $column !== 'form_id' && $column !== 'parent_id';
        });

        // map columns to user-friendly names
        $formattedColumns = array_map(function ($column) {
            return ucwords(str_replace('_', ' ', $column));
        }, $columns);

        $callback = function () use ($formattedColumns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $formattedColumns);
            fclose($file);
        };

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="sample-file.csv"',
        ];

        return Response::stream($callback, 200, $headers);
    }

    public function upload_file_backup(Request $request)
    {
        // Custom validation messages
        $messages = [
            'fileUpload.required' => 'The file upload is required.',
            'fileUpload.file' => 'The uploaded file must be a valid file.',
            'fileUpload.mimes' => 'The uploaded file must be a file of type: csv, txt.',
            'form_id.required' => 'The form ID is required.',
            'form_id.exists' => 'The selected form ID is invalid.',
        ];

        // Validate the request
        $validator = Validator::make($request->all(), [
            'fileUpload' => 'required|file|mimes:csv,txt',
            'form_id' => 'required|exists:leads_form,form_id'
        ], $messages);

        if ($validator->fails()) {
            // Collect validation error messages
            $errorMessages = implode(' ', $validator->errors()->all());
            return redirect()->back()->with('error', $errorMessages)->withInput();
        }

        $formId = $request->input('form_id');
        $parentId = DB::table('leads_form')->where('form_id', $formId)->value('parent_id');

        //uploaded file code
        if ($request->hasFile('fileUpload')) {
            $file = $request->file('fileUpload');
            $path = $file->getRealPath();

            // Open and read the CSV file
            $handle = fopen($path, 'r');
            $header = fgetcsv($handle, 1000, ',');

            // Check if the header matches the expected columns
            if ($header && count($header) > 0) {
                // Get fields configuration from LeadFormDetail
                $fieldsConfig = LeadFormDetail::where('form_id', $formId)->get()->groupBy('table_name');

                // Begin a database transaction
                DB::beginTransaction();

                try {
                    $errors = []; // To collect validation errors

                    while (($data = fgetcsv($handle, 1000, ',')) !== FALSE) {
                        $csvData = array_combine($header, $data);

                        // Validate required fields and unique email
                        $validator = Validator::make($csvData, [
                            'first_name' => 'required|string|max:191',
                            'last_name' => 'required|string|max:191',
                            'title' => 'required|string|max:191',
                            'email' => 'nullable|string|email|max:191|unique:leads,email',
                            'phone' => 'required|string|max:191',
                        ]);

                        if ($validator->fails()) {
                            $errors[] = $validator->errors()->all();
                            continue; // Skip to next iteration if validation fails
                        }

                        // Insert data into the Lead table
                        $leadData = [];
                        foreach ((new Lead)->getFillable() as $field) {
                            if (isset($csvData[$field])) {
                                //empty strings and set to NULL if empty
                                $leadData[$field] = $csvData[$field] === '' ? NULL : $csvData[$field];
                            }
                        }

                        $leadData['form_id'] = $formId;
                        $leadData['lead_status'] = '1';
                        $leadId = DB::table('leads')->insertGetId($leadData);
                        if (!$leadId) {
                            throw new \Exception("Failed to insert lead data and retrieve lead ID.");
                        }

                        // Insert data into the respective tables based on the configuration
                        foreach ($fieldsConfig as $tableName => $fields) {
                            $insertData = [
                                'lead_id' => $leadId,
                                'form_id' => $formId,
                            ];
                            if ($parentId !== null) {
                                $insertData['parent_id'] = $parentId;
                            }

                            foreach ($fields as $field) {
                                if (isset($csvData[$field->field_name])) {
                                    // Check for empty strings and set to NULL if empty
                                    $insertData[$field->field_name] = $csvData[$field->field_name] === '' ? NULL : $csvData[$field->field_name];
                                }
                            }

                            if (!empty($insertData)) {
                                DB::table($tableName)->insert($insertData);
                            }
                        }
                    }

                    fclose($handle);

                    // Commit the transaction
                    DB::commit();

                    if (!empty($errors)) {
                        return redirect()->back()->with('error', 'Validation failed for some records. Errors:' . json_encode($errors));
                    } else {
                        return redirect()->back()->with('success', 'File uploaded and data inserted successfully.');
                    }
                } catch (\Exception $e) {
                    // Rollback the transaction if something goes wrong
                    DB::rollback();

                    return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage());
                }
            } else {
                return redirect()->back()->with('error', 'Invalid CSV file format.');
            }
        } else {
            return redirect()->back()->with('error', 'File not uploaded.');
        }
    }



    public function upload_file(Request $request)
    {
        //custom validation messages
        $messages = [
            'fileUpload.required' => 'The file upload is required.',
            'fileUpload.file' => 'The uploaded file must be a valid file.',
            'fileUpload.mimes' => 'The uploaded file must be a file of type: csv',
            'form_id.required' => 'The form ID is required.',
            'form_id.exists' => 'The selected form ID is invalid.',
        ];

        // Validate the request
        $validator = Validator::make($request->all(), [
            //'fileUpload' => 'required|file|mimes:csv',
            'fileUpload' => 'required|file|mimes:csv,txt,xls,xlsx',
            'form_id' => 'required|exists:leads_form,form_id'
        ], $messages);

        if ($validator->fails()) {
            // Collect validation error messages
            $errorMessages = implode(' ', $validator->errors()->all());
            return redirect()->back()->with('error', $errorMessages)->withInput();
        }

        $formId = $request->input('form_id');
        $parentId = DB::table('leads_form')->where('form_id', $formId)->value('parent_id');

        // Uploaded file code
        if ($request->hasFile('fileUpload')) {
            $file = $request->file('fileUpload');
            $path = $file->getRealPath();

            // Open and read CSV file
            $handle = fopen($path, 'r');
            $header = fgetcsv($handle, 1000, ',');


            //header to convert spaces to underscores and uppercase to lowercase
            $dbHeader = array_map(function ($column) {
                $column = str_replace(' ', '_', $column);
                $column = strtolower($column);
                return $column;
            }, $header);

            // Check if the header matches the expected columns
            if ($dbHeader && count($dbHeader) > 0) {
                // Get fields from LeadFormDetail
                $fieldsConfig = LeadFormDetail::where('form_id', $formId)->get()->groupBy('table_name');

                //collect all CSV data and validation errors
                $allCsvData = [];
                $errors = []; //collect validation errors
                $rowNumber = 2; // Start from the second row because the first row is the header

                while (($data = fgetcsv($handle, 1000, ',')) !== FALSE) {
                    //dd($header);die();
                    $csvData = array_combine($dbHeader, $data);
                    //dd($csvData['dob']);die();
                    //$csvData['dob'] = $this->convertDate($csvData['dob']);
                    foreach ($fieldsConfig as $tableFields) {
                        foreach ($tableFields as $field) {
                            if ($field->field_value === 'date' && isset($csvData[$field->field_name])) {
                                $csvData[$field->field_name] = $this->convertDate($csvData[$field->field_name]);
                            }
                        }
                    }

                    // dd($csvData);die();

                    // custom validation rules for each field based on their types
                    $fieldValidations = [];
                    foreach ($fieldsConfig as $tableFields) {
                        foreach ($tableFields as $field) {
                            $fieldName = $field->field_name;
                            $fieldType = $field->field_value;

                            switch ($fieldType) {
                                case 'varchar':
                                case 'char':
                                case 'text':
                                    $fieldValidations[$fieldName] = 'nullable|string';
                                    break;
                                case 'int':
                                    $fieldValidations[$fieldName] = 'nullable|integer';
                                    break;
                                case 'date':
                                    $fieldValidations[$fieldName] = 'nullable|date';
                                    break;
                                case 'boolean':
                                    $fieldValidations[$fieldName] = 'nullable|boolean';
                                    break;
                                default:
                                    $fieldValidations[$fieldName] = 'nullable';
                            }
                        }
                    }

                    // Validate required fields and unique email
                    $fieldValidations = array_merge($fieldValidations, [
                        'first_name' => 'required|string|max:191',
                        'last_name' => 'required|string|max:191',
                        //'title' => 'required|string|max:191',
                        'email' => 'nullable|string|email|max:191|unique:leads,email',
                        'phone' => 'required|string|max:191',
                    ]);

                    // Validate the CSV row
                    $validator = Validator::make($csvData, $fieldValidations);


                    if ($validator->fails()) {

                        $errors[] = ['row' => $rowNumber, 'messages' => $validator->errors()->all()];
                    } else {

                        $allCsvData[] = $csvData; // Only collect valid data
                    }
                    $rowNumber++;
                }

                fclose($handle);

                if (!empty($errors)) {
                    $errorMessages = [];
                    foreach ($errors as $error) {
                        $errorMessages[] = 'Row ' . $error['row'] . ': ' . implode(' ', $error['messages']);
                    }
                    return redirect()->back()->with('error', 'Validation failed for some records. Errors:' . json_encode($errorMessages));
                }

                // Begin a database transaction
                DB::beginTransaction();

                try {
                    $insertedCount = 0; // count the number of successfully inserted data

                    foreach ($allCsvData as $csvData) {
                        //dd($header);die();
                        // insert data into the Lead table
                        $leadData = [];
                        foreach ((new Lead)->getFillable() as $field) {
                            if (isset($csvData[$field])) {
                                // Empty strings and set to NULL if empty
                                $leadData[$field] = $csvData[$field] === '' ? NULL : $csvData[$field];
                            }
                        }

                        $leadData['form_id'] = $formId;
                        $leadData['lead_status'] = '1';
                        $leadData['created_by'] = auth()->id();
                        $phone=$leadData['phone'];
                        //ensure the phone number starts with '0'
                        if (substr($leadData['phone'], 0, 1) !== '0') {
                            $leadData['phone'] = '0' .$phone;
                        }
                       
                        $leadId = DB::table('leads')->insertGetId($leadData);
                        //dd($leadData);die();

                        if (!$leadId) {
                            throw new \Exception("Failed to insert lead data and retrieve lead ID.");
                        }


                        // insert data into the tables based on the config
                        foreach ($fieldsConfig as $tableName => $fields) {

                            $insertData = [
                                'lead_id' => $leadId,
                                'form_id' => $formId,
                            ];

                            if ($parentId !== null) {
                                $insertData['parent_id'] = $parentId;
                            }


                            // foreach ($fields as $field) {
                            //     if (isset($csvData[$field->field_name])) {
                            //         // Check for empty strings and set to NULL if empty
                            //         $insertData[$field->field_name] = $csvData[$field->field_name] === '' ? NULL : $csvData[$field->field_name];
                            //     }
                            // }

                            foreach ($fields as $field) {
                                // If the field is of type 'file', insert NULL
                                if ($field->field_value === 'file') {
                                    $insertData[$field->field_name] = '';
                                } elseif (isset($csvData[$field->field_name])) {
                                    // Check for empty strings and set to NULL if empty
                                    $insertData[$field->field_name] = $csvData[$field->field_name] === '' ? NULL : $csvData[$field->field_name];
                                }
                            }

                            if (!empty($insertData)) {
                                //dd($insertData);die();
                                DB::table($tableName)->insert($insertData);
                            }
                        }


                        // increment the count
                        $insertedCount++;
                    }



                    // Commit the transaction
                    DB::commit();
                    Helper::storeLog("Lead File uploaded and data inserted successfully", "Lead", "Upload Lead",$leadId);

                    return redirect()->back()->with('success', "File uploaded and data inserted successfully. Number of records inserted: $insertedCount.");
                } catch (\Exception $e) {
                    // Rollback the transaction if something goes wrong error
                    DB::rollback();

                    return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage());
                }
            } else {
                return redirect()->back()->with('error', 'Invalid CSV file format.');
            }
        } else {
            return redirect()->back()->with('error', 'File not uploaded.');
        }
    }

    public function upload_json_file(Request $request) {
        // dd($request->form_id);
        $form_id = $request->form_id;
        $messages = [
            'fileUpload.required' => 'The file upload is required.',
            'fileUpload.file' => 'The uploaded file must be a valid file.',
            'fileUpload.mimes' => 'The uploaded file must be a file of type: json',
            // 'form_id.required' => 'The form ID is required.',
            // 'form_id.exists' => 'The selected form ID is invalid.',
        ];
        // Validate the request
        $validator = Validator::make($request->all(), [
            'fileUpload' => 'required|file|mimes:json,txt'
        ], $messages);

        if ($validator->fails()) {
            // Collect validation error messages
            $errorMessages = implode(' ', $validator->errors()->all());
            return redirect()->back()->with('error', $errorMessages)->withInput();
        }



        $file = $request->file('fileUpload');
        $path = $file->getRealPath();
        $data = file_get_contents($path);
        // $data = json_decode($data);
        $jdata = json_decode($data, true);
        $quote_data = $jdata['QuoteData'];

        // ratedata for another use
        $api_analysis_data = null;
        $api_quote_data = null;
        if(isset($jdata['RateAnalysisResults'])) {
            $rate_data = $jdata['RateAnalysisResults'];
            $api_analysis_data = json_encode($rate_data);
        }

        if(isset($jdata['QuoteData'])) {
            $api_quote_data = json_encode($jdata['QuoteData']);
        }


        $lines = explode("\r\n", $quote_data);
        $result = [];
        $driver1 = [];
        $cardata1 = [];


        foreach($lines as $line) {
            $parts = str_getcsv($line);

            if(isset($parts[0], $parts[2]) && $parts[1]=="pol0") {
                $result[$parts[0]] = $parts[2];
            }
            if(isset($parts[0], $parts[2]) && $parts[1]=="drv1") {
                $driver1[$parts[0]] = $parts[2];
            }
            if(isset($parts[0], $parts[2]) && $parts[1]=="car1") {
                $cardata1[$parts[0]] = $parts[2];
            }
        }



        // check for dublication
        $chk_data = Lead::where('email', $result['emailaddress'])->first();
        if(!empty($chk_data)) {
            return redirect()->back()->with('error', "Dublicate lead found");
        }

        DB::beginTransaction();
        $lead = new Lead();
        $lead->form_id = $form_id;
        $lead->first_name = $result['firstname'];
        $lead->last_name = $result['lastname'];
        $lead->email = $result['emailaddress'];
        $lead->phone = $result['cellphone'];
        $lead->home_phone = $result['homephone'];
        $lead->work_phone = $result['workphone'];
        $lead->time_at_residence = $result['residetime'];
        $lead->gender = $result['gender'];
        $lead->dob = date("Y-m-d", strtotime($result['dob']));
        $lead->marital_status = $result['marital'];
        $lead->address = $result['address1'];
        $lead->prior_address = $result['prioraddr1'];
        $lead->age = $result['age'];
        $lead->lead_status = "New";
        $lead->city = $result['city'];
        $lead->zip = $result['zipcode'];
        $lead->state = $result['state'];
        $lead->country = $result['countryoforigin'];
        $lead->language = $result['nativelanguage'];
        $lead->save();
        $lead_id = $lead->id;


        // insert into general information
        $gninfo = new GeneralInformation();
        $gninfo->lead_id = $lead_id;
        $gninfo->form_id = $form_id;
        $gninfo->created_by = Auth::user()->id;
        $gninfo->effective_date = date("Y-m-d", strtotime($result['datequoted']));
        $gninfo->policy_term = $result['priorinsurance'];
        // $gninfo->policy_term = null;
        $gninfo->payment_option = $result['paymentmethod'];
        $gninfo->exclusions = $result['numofexclusions'];
        $gninfo->allow_credit_score = $result['creditscore'];
        $gninfo->non_owner = $result['nonowner'];
        $gninfo->broadform = $result['broadform'];
        $gninfo->liability = null;
        $gninfo->pip = $cardata1['pip'];
        $gninfo->medical_payments = null;
        $gninfo->uninsured_bi = $cardata1['uninsbi'];
        $gninfo->uninsured_pd = $cardata1['uninspd'];
        $gninfo->accidental_death = null;
        $gninfo->save();

        // insert into quotes data
        $qdata = new QuoteDetails();
        $qdata->lead_id = $lead_id;
        $qdata->form_id = $form_id;
        $qdata->created_by = Auth::user()->id;
        $qdata->contact_method = $result['contactsource'];
        $qdata->preferred_contact = $result['preferredcontact'];
        $qdata->lead_source = $result['leadsource'];
        $qdata->marketing_number = $result['marketingnumber'];
        $qdata->quote_description = $result['quotedescription'];
        $qdata->native_language = $result['nativelanguage'];
        $qdata->paperles_discount = $result['paperlessdiscount'];
        $qdata->save();

        // insert into driver information
        $dvinfo = new DriverInformation();
        $dvinfo->lead_id = $lead_id;
        $dvinfo->form_id = $form_id;
        $dvinfo->created_by = Auth::user()->id;
        // $dvinfo->drivers = $result['numofdrivers'];
        $dvinfo->driver_type = $driver1['persontype'];
        $dvinfo->full_name = $driver1['firstname']." ".$driver1['middlename']." ".$driver1['lastname'];
        $dvinfo->dob = date("Y-m-d", strtotime($driver1['dob']));
        $dvinfo->age = $driver1['age'];
        $dvinfo->gender = $driver1['gender'];
        $dvinfo->marital = $driver1['marital'];
        $dvinfo->relationship = $driver1['relation'];
        $dvinfo->dl_number = $driver1['drvlicensenumber'];
        $dvinfo->save();

        // insert into driver attribute
        $dvattr = new DriverAttributes();
        $dvattr->lead_id = $lead_id;
        $dvattr->form_id = $form_id;
        $dvattr->created_by = Auth::user()->id;
        $dvattr->prior_insurance = $driver1['priorinsurance'];
        $dvattr->reason_for_no_insurance = $driver1['reasonfornoinsurance'];
        $dvattr->time_licensed_us = $driver1['monthslicensed'];
        $dvattr->time_licensed_texas = $driver1['monthslicensedstate'];

        $dvattr->foreign_licensed = $driver1['monthsforeignlicense'];
        $dvattr->foreign_licensed_experience = $driver1['monthsforeignlicense'];

        $dvattr->sr_22_reason_filling = $driver1['sr22reason'];
        $dvattr->suspended_license = $driver1['suspendedlic'];
        $dvattr->time_since_suspension = $driver1['monthssuspended'];
        $dvattr->industry = $driver1['industryoccupation'];
        $dvattr->occupation = $driver1['occupation'];
        $dvattr->time_employed = $driver1['employedtime'];
        $dvattr->education_level = $driver1['educationlevel'];
        $dvattr->residence_type = $driver1['residencytype'];
        $dvattr->residence_status = $driver1['residencystatus'];
        $dvattr->property_insurance = $driver1['propertyinsurance'];
        $dvattr->companion_home = $driver1['isacompany'];
        $dvattr->driver_training = $driver1['driverstraining'];
        $dvattr->defensive_driving = $driver1['defensivedriving'];
        $dvattr->sr22 = $driver1['sr22'];
        $dvattr->sr22a = $driver1['sr22a'];
        $dvattr->save();

        // insert into vehicle information
        $vidata = new VehicleInformation();
        $vidata->lead_id = $lead_id;
        $vidata->form_id = $form_id;
        $vidata->created_by = Auth::user()->id;
        // $vidata->cars = $cardata1['policylinkid'];
        $vidata->car_type = $cardata1['vehicletype'];
        $vidata->vin = $cardata1['vin'];
        $vidata->model_year = $cardata1['year'];
        $vidata->make = $cardata1['maker'];
        $vidata->model = $cardata1['model'];
        $vidata->license_plate_no = $cardata1['licenseplatenumber'];
        $vidata->zip_code = $cardata1['zipcode'];
        $vidata->country = $cardata1['county'];
        $vidata->city = $cardata1['city'];
        $vidata->alternate_garage = $cardata1['garaged'];
        $vidata->loss_payee_type = $cardata1['purchasetype'];
        $vidata->comp = $cardata1['comp'];
        $vidata->coll = $cardata1['coll'];
        $vidata->towing = $cardata1['towing'];
        $vidata->rental = $cardata1['rental'];
        $vidata->custom = $cardata1['custom'];
        $vidata->gap = $cardata1['gapcoverage'];
        $vidata->save();

        // insert into vehicle attributes
        $vi_attr = new VehicleAttributes();
        $vi_attr->lead_id = $lead_id;
        $vi_attr->form_id = $form_id;
        $vi_attr->created_by = Auth::user()->id;
        $vi_attr->usage = $cardata1['usage'];
        $vi_attr->ride_share = $cardata1['rideshare'];
        $vi_attr->primary_operator = $cardata1['primaryoperator'];
        $vi_attr->percent_driven_to_work = $cardata1['percenttowork'];
        $vi_attr->telematics = null;
        $vi_attr->miles_driven_to_work = $cardata1['miles'];
        $vi_attr->annual_miles_driven = $cardata1['annualmiles'];
        $vi_attr->odometer = $cardata1['odometer'];
        $vi_attr->purchase_cost = $cardata1['purchasecost'];
        $vi_attr->msrp = $cardata1['msrp'];
        $vi_attr->acv = $cardata1['acv'];
        $vi_attr->purchase_date = date("Y-m-d", strtotime($cardata1['purchasedate']));
        $vi_attr->new_or_used = null;
        $vi_attr->leased_vehicle = $cardata1['leasedvehicle'];
        $vi_attr->salvaged = $cardata1['salvaged'];
        $vi_attr->anti_theft = $cardata1['antitheft'];
        $vi_attr->save();

        // save api data
        $rate_api = new RateAnalysisData();
        $rate_api->lead_id = $lead_id;
        $rate_api->form_id = $form_id;
        $rate_api->created_by = Auth::user()->id;
        $rate_api->rate_analysis_data = $api_analysis_data;
        $rate_api->quote_data = $api_quote_data;
        $rate_api->save();

        DB::commit();

        Helper::storeLog("Json File uploaded and data inserted successfully", "Lead", "Upload Json",$lead_id);
        return redirect()->back()->with('success', "File uploaded and data inserted successfully.");
    }



    private function convertDate($dateString)
    {
        if (empty($dateString)) {
            return null;
        }

        $formats = [
            'd/m/Y',  // day/month/year (e.g., 01/10/2024)
            'm/d/Y',  // month/day/year (e.g., 10/01/2024)
            'Y-m-d',  // year-month-day (e.g., 2024-10-01)
            'Y/m/d',  // year/month/day (e.g., 2024/10/01)
            'd-m-Y',  // day-month-year (e.g., 01-10-2024)
            'm-d-Y',  // month-day-year (e.g., 10-01-2024)
            'Y.m.d',  // year.month.day (e.g., 2024.10.01)
            'd.m.Y',  // day.month.year (e.g., 01.10.2024)
            'd/m/y',  // day/month/two-digit year (e.g., 01/10/24)
            'm/d/y',  // month/day/two-digit year (e.g., 10/01/24)
            'd-m-y',  // day-month-two-digit year (e.g., 01-10-24)
            'm-d-y',  // month-day-two-digit year (e.g., 10-01-24)
            'd.m.y',  // day.month.two-digit year (e.g., 01.10.24)
            'd/m/y',  // day/month/two-digit year (e.g., 1/10/24)
            'd.m.y',  // day.month.two-digit year (e.g., 1.10.24)
            'd M Y',  // day Month year (e.g., 1 Jan 2023)
            'M d, Y', // Month day, year (e.g., Jan 1, 2023)
            'd-M-Y',  // day-Month-year (e.g., 01-Jan-2023)
            'Ymd',    // yearmonthday (e.g., 20231001)
            'dmy',    // daymonthyear (e.g., 01102023)
            'mdY',    // monthdayyear (e.g., 10012023)
        ];

        foreach ($formats as $format) {
            $date = DateTime::createFromFormat($format, $dateString);
            if ($date) {
                return $date->format('Y-m-d'); // Return in Y-m-d format
            }
        }

        return null;
    }

    
    private function convertDate_backup($dateString)
    {
        if (empty($dateString)) {
            return null;
        }

        $date = DateTime::createFromFormat('d/m/Y', $dateString);
        if (!$date) {
            $date = DateTime::createFromFormat('m/d/Y', $dateString);
        }

        return $date ? $date->format('Y-m-d') : null;
    }
    

    public function search_phone($data) {
        $searchTerm = trim($data);
        $formName = [];

        if (empty($searchTerm)) {
            return redirect()->route('lead-index')->with('error', 'Search Field cannot be blank.');
        }

        $leads = $this->leadService->search_on_url($data);
        if ($leads->isEmpty()) {
            // dd("ami here");
            return redirect('/lead/create?form_id=3092288972&phone='.$data)->with('error', 'No data found');
        }
        
        return redirect()->route('lead-show', $leads[0]->id);
    }


    public function updateLeadProfileImage($id)
    {
        $lead = Lead::findOrFail($id);
        if ($lead->profile_image) {
            // Path to the image file
            //$imagePath = public_path('uploads/agents/' . $lead->profile_image);
            $imagePath =getcwd().'/uploads/leads/'.$lead->profile_image;
    
            // Ddlete the file if it exists
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
    
            //update the user record to remove the profile image
            $lead->profile_image = null;
            $lead->save();
    
            return response()->json(['success' => true]);
        }
    
        return response()->json(['success' => false, 'message' => 'No profile image found']);
    }

    public function lead_status_list() {
        $data = LeadStatus::all();
        return view('leads.lead_status_list', compact('data'));
    }

    public function add_status_code() {
        return view('leads.add_status_code');
    }

    public function save_status_code(Request $request) {
        // dd($request->all());
        $code = new LeadStatus([
            'status_name' => $request->status_name,
            'status' => $request->status
        ]);
        $code->save();
        Helper::storeLog("Lead status created successfully", "Lead Status", "Create Status");
        return redirect()->route('lead-status-list')->with('success', 'Status created successfully.');
    }

    public function edit_status_code($id) {
        $data = LeadStatus::findorfail($id);
        return view('leads.edit_status_code', compact('data'));
    }

    public function update_status_code(Request $request) {
        // dd($request->all());
        $data = LeadStatus::findorfail($request->id);
        $data->status_name = $request->status_name;
        $data->status = $request->status;
        $data->update();
        return redirect()->route('lead-status-list')->with('success', 'Status updated successfully.');
    }

    public function leadCycleBroadcast() {
        $this->leadService->leadCycleBroadcast();
    }

    public function lead_distribution() {
        $data['dist_list'] = LeadCycle::leftJoin('leads', 'lead_cycle.lead_id', '=', 'leads.id')
        ->leftJoin('users', 'lead_cycle.user_id', '=', 'users.id')
        ->select(
            'lead_cycle.*',
            'leads.first_name',
            'leads.last_name',
            'users.username',
        )
        ->whereIn('lead_cycle.status', [0,1,3])
        ->orderBy('cycle_time', 'asc')
        ->get();
        return view('leads.lead_distribution', $data);
    }

    
}
