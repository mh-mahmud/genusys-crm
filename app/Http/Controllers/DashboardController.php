<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\User;
use App\Models\Lead;
use App\Models\LeadsForm;
use App\Models\Agent;
use App\Models\Product;
use App\Models\Campaign;
use App\Models\Task;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\ProductSpecification;
use App\Models\Customer;
use App\Models\Notification;
use App\Models\Invoice;
use App\Models\LeadCycle;

class DashboardController extends Controller
{

    public function __construct()
    {
        // $this->middleware(['auth']);
    }

    public function dashboard()
    {

        $data = [];
        $data['invoice_count'] = Invoice::where('invoice_status', 'Unpaid')->count();
        $user_id = Auth::user()->id;
        if (Auth()->user()->user_type == 'admin') {
            $data['lead_list'] = Lead::with('assigned_name')->orderBy('id', 'desc')->limit(5)->get(['id', 'first_name', 'middlename', 'last_name', 'email', 'phone', 'gender', 'age', 'lead_source', 'lead_status', 'assigned_to']);
        } else {
            $data['lead_list'] = Lead::with('assigned_name')->where('created_by', Auth::user()->id)->orderBy('id', 'desc')->limit(5)->get(['id', 'first_name', 'middlename', 'last_name', 'email', 'phone', 'gender', 'age', 'lead_source', 'lead_status', 'assigned_to']);
        }

        // dd($data);

        $invoice_query = Invoice::join('customers', 'invoices.customer_id', '=', 'customers.id')
            ->join('leads', 'customers.lead_id', '=', 'leads.id')
            ->select('invoices.*', 'customers.customer_group', 'leads.first_name', 'leads.last_name')
            ->orderBy('invoices.created_at', 'desc');

        if (!Auth::user()->hasPermission('can-see-invoice')) {
            $invoice_query->where('invoices.created_by', Auth::id());

        }

        $data['invoice_list'] = $invoice_query->limit(5)->get();
        $data['dist_list'] = LeadCycle::leftJoin('leads', 'lead_cycle.lead_id', '=', 'leads.id')
        ->leftJoin('users', 'lead_cycle.user_id', '=', 'users.id')
        ->select(
            'lead_cycle.*',
            'leads.first_name',
            'leads.last_name',
            'leads.middlename',
            'leads.email',
            'leads.phone',
            'leads.lead_status',
            'users.username',
        )
        // ->whereIn('lead_cycle.status', [0,1,3])
        ->whereIn('lead_cycle.status', [2])
        ->orderBy('cycle_time', 'asc')
        ->limit(5)
        ->get();

        if (Auth()->user()->user_type == 'admin') {
            $data['camp_list'] = Campaign::where('status', 1)->orderBy('id', 'desc')->limit(5)->get(['id', 'campaign_title', 'start_date', 'end_date', 'campaign_type', 'campaign_limit']);
        } else {
            $data['camp_list'] = Campaign::where('status', 1)->where('created_by', Auth::user()->id)->orderBy('id', 'desc')->limit(5)->get(['id', 'campaign_title', 'start_date', 'end_date', 'campaign_type', 'campaign_limit']);
        }

        if (Auth()->user()->user_type == 'admin') {
            $data['totalWorkOrderNumber'] = ProductSpecification::join('customers', 'product_specification.customer_id', '=', 'customers.id')
            ->join('leads', 'customers.lead_id', '=', 'leads.id')
            ->whereNotNull('product_specification.work_order_number')
            ->where('product_specification.work_order_number', '<>', '')
            //->where('leads.created_by', Auth::id()) 
            //->distinct('product_specification.work_order_number')
            ->count('product_specification.work_order_number');

            $data['totalWorkOrderValue'] = ProductSpecification::join('customers', 'product_specification.customer_id', '=', 'customers.id')
            ->join('leads', 'customers.lead_id', '=', 'leads.id') 
            //->where('leads.created_by', Auth::id()) 
            ->sum('product_specification.work_order_value');

            $data['totalAmcEffectiveAmount'] = ProductSpecification::join('customers', 'product_specification.customer_id', '=', 'customers.id')
            ->join('leads', 'customers.lead_id', '=', 'leads.id')
            //->where('leads.created_by', Auth::id())
            ->sum('product_specification.amc_effective_amount');

            $data['totalAmcRate'] = ProductSpecification::join('customers', 'product_specification.customer_id', '=', 'customers.id')
            ->join('leads', 'customers.lead_id', '=', 'leads.id')
            //->where('leads.created_by', Auth::id())
            ->avg('product_specification.amc_rate');

        } else {
            $data['totalWorkOrderNumber'] = ProductSpecification::join('customers', 'product_specification.customer_id', '=', 'customers.id')
            ->join('leads', 'customers.lead_id', '=', 'leads.id') 
            ->whereNotNull('product_specification.work_order_number')
            ->where('product_specification.work_order_number', '<>', '')
            //->where('leads.created_by', Auth::id()) 
            //->distinct('product_specification.work_order_number')
            ->count('product_specification.work_order_number');

            $data['totalWorkOrderValue'] = ProductSpecification::join('customers', 'product_specification.customer_id', '=', 'customers.id')
            ->join('leads', 'customers.lead_id', '=', 'leads.id') 
            //->where('leads.created_by', Auth::id()) 
            ->sum('product_specification.work_order_value');

            $data['totalAmcEffectiveAmount'] = ProductSpecification::join('customers', 'product_specification.customer_id', '=', 'customers.id')
            ->join('leads', 'customers.lead_id', '=', 'leads.id')
            //->where('leads.created_by', Auth::id())
            ->sum('product_specification.amc_effective_amount');

            $data['totalAmcRate'] = ProductSpecification::join('customers', 'product_specification.customer_id', '=', 'customers.id')
            ->join('leads', 'customers.lead_id', '=', 'leads.id')
            //->where('leads.created_by', Auth::id())
            ->avg('product_specification.amc_rate');
        }
        // $data['agent_list'] = Agent::with('user')->where('status', 1)->orderBy('agent_id', 'desc')->limit(5)->get();
        $task_query = Task::where('tasks.status', '!=', config('constants.TASK_STATUS_CLOSED_ID'));
        if (!Auth::user()->hasPermission('can-see-tasks')) {
            $task_query->where('assigned_to', Auth::id());

        }
        $data['todo_list'] = $task_query->orderBy('id', 'DESC')->limit(6)->get();
        // $data['todo_list'] = (Auth()->user()->user_type == 'admin') ? Task::where('status', '!=', 9)->limit(6)->get(['task_name', 'description', 'due_date', 'status']) : Task::where('created_by', $user_id)->orWhere('assigned_to', $user_id)->limit(6)->get(['task_name', 'description', 'due_date', 'status']);
        $data['notifications'] = Notification::leftJoin('leads', 'notifications.lead_id', '=', 'leads.id')
        ->leftJoin('users', 'notifications.notify_by', '=', 'users.id')
        ->select(
            'notifications.*',
            'leads.first_name as lead_first_name',
            'leads.last_name as lead_last_name',
            'leads.email as lead_email',
            'users.first_name as user_first_name',
            'users.last_name as user_last_name',
            'users.email as user_email'
        )
        ->where('notifications.notify_by', '=', auth()->id())
        ->orderBy('notify_datetime', 'desc')
        ->limit(5)
        ->get();

        $data['formName'] = $formName = LeadsForm::whereNull('parent_id')->pluck('form_name', 'form_id');

        //$data['count_lead'] = Lead::where('lead_status', 1)->count();
        $data['count_lead'] = Lead::where('lead_rating', '=', null)->count();
        $data['total_customers'] = Customer::count();
        $data['active_agents'] = Agent::where('status', 1)->count();
        $data['active_products'] = Product::where('status', 1)->count();
        $data['const_task'] = config('constants.TASK_STATUS');
        // dd($data);
        return view('dashboard', $data);
    }

    function profile()
    {
        return view('single_form');
    }
}
