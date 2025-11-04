<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\Invoice;
use App\Services\InvoiceService;
use App\Services\CountryService;
use App\Services\CurrencyService;
use PHPUnit\TextUI\Help;
use App\Helpers\Helper;
use App\Models\Agent;
use App\Models\Product;
use App\Models\InvoiceCustomForm;
use App\Models\ProductSpecification;
use App\Services\ProductSpecificationService;
use Carbon\Carbon;
use PDF;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class InvoiceController extends Controller
{
    protected $invoiceService;
    protected $countryService;
    protected $currencyService;

    public function __construct(InvoiceService $invoiceService, CountryService $countryService, CurrencyService $currencyService)
    {
        $this->invoiceService = $invoiceService;
        $this->countryService  = $countryService;
        $this->currencyService  = $currencyService;
    }

    public function index()
    {
        //$invoices = Invoice::all();
        $userRole = DB::table('users')
        ->join('roles', 'users.role_id', '=', 'roles.id')
        ->where('users.id', Auth::id())
        ->select('roles.slug')
        ->value('slug');
        $invoices = $this->invoiceService->getAllInvoices();
        return view('invoices.index', compact('invoices','userRole'));
    }


  

    public function create_backup(Request $request)
    {
        //$customers = Customer::all();
        $customers = Customer::join('leads', 'customers.lead_id', '=', 'leads.id')
        ->select('customers.*', 'leads.first_name', 'leads.last_name')
        ->get();
        $countries = $this->countryService->countryList($request);
        $currencies = $this->currencyService->currencyList($request);
        $lastInvoice = Invoice::latest()->first();
        $nextInvoiceNumber = $lastInvoice ? $lastInvoice->id + 1 : 1;
        $discountTypes = Helper::getEnumValues('invoices', 'discount_type');
        $agents = Agent::select('agent_id', 'first_name', 'last_name','user_id')->get();
        $wordOrderNumbers = ProductSpecification::select('id', 'work_order_number')->get();
        $custom_invoice = InvoiceCustomForm::select('id', 'invoice_name','field_details','footer_details')->get();
        //$products = Product::select('id', 'name', 'description', 'product_value')->get();
        $products = Product::select('id', 'name', 'description', 'product_value')->where('status', 1)->get();
        return view('invoices.create', compact('customers', 'countries', 'currencies', 'nextInvoiceNumber', 'discountTypes', 'agents', 'products','custom_invoice','wordOrderNumbers'));
    }


    public function create(Request $request, $leadid = null)
    {
        if ($leadid) {
            
            $customers = Customer::join('leads', 'customers.lead_id', '=', 'leads.id')
                ->where('leads.id', $leadid)
                ->select('customers.*', 'leads.first_name', 'leads.last_name','leads.address')
                ->get();
                //dd($customers);
        } else {
            
            $customers = Customer::join('leads', 'customers.lead_id', '=', 'leads.id')
                ->select('customers.*', 'leads.first_name', 'leads.last_name','leads.address')
                ->get();
        }
        $countries = $this->countryService->countryList($request);
        $currencies = $this->currencyService->currencyList($request);
        $lastInvoice = Invoice::latest()->first();
        $nextInvoiceNumber = $lastInvoice ? $lastInvoice->id + 1 : 1;
        $discountTypes = Helper::getEnumValues('invoices', 'discount_type');
        $agents = Agent::select('agent_id', 'first_name', 'last_name','user_id')->get();
        //$wordOrderNumbers = ProductSpecification::select('id', 'work_order_number')->get();
        if ($leadid) {
            $wordOrderNumbers = ProductSpecification::join('customers', 'product_specification.customer_id', '=', 'customers.id')
                ->where('customers.lead_id', $leadid)
                ->select('product_specification.id', 'product_specification.work_order_number')
                ->get();
        } else {
            $wordOrderNumbers = ProductSpecification::select('id', 'work_order_number')->get();
        }
        $custom_invoice = InvoiceCustomForm::select('id', 'invoice_name','field_details','footer_details')->get();
        $products = Product::select('id', 'name', 'description', 'product_value')->where('status', 1)->get();
        return view('invoices.create', compact('customers', 'countries', 'currencies', 'nextInvoiceNumber', 'discountTypes', 'agents', 'products','custom_invoice','wordOrderNumbers', 'leadid'));
    }


    

    public function store_backup(Request $request)
    {
        $validatedData = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'invoice_number' => 'required|unique:invoices,invoice_number',
            'invoice_date' => 'required|date',
            'due_date' => 'nullable|date|after_or_equal:invoice_date',
            'product_id' => 'required|exists:products,id',
        ], [
            'product_id.required' => 'Product item is required',
        ]);
        $invoice = $this->invoiceService->createInvoice($request->all());
        return redirect()->route('invoice-index')->with('success', 'Invoice Created Successfully!');
    }

    public function store(Request $request)
    {
        if (!$request->filled('custom_invoice_id')) {
            $validatedData = $request->validate([
                'customer_id' => 'required|exists:customers,id',
                //'invoice_number' => 'required|unique:invoices,invoice_number',
                'invoice_date' => 'required|date',
                'invoice_status' => 'required',
                'due_date' => 'nullable|date|after_or_equal:invoice_date',
                //'product_id' => 'required|exists:products,id',
                //item validation
                'items.item_name.*' => 'required|string',
                'items.quantity.*' => 'required|integer|min:1',
                'items.rate.*' => 'required|numeric|min:0',
                'items.tax.*' => 'nullable|numeric|min:0|max:100',
            ], [
                'items.item_name.*.required' => 'Item Name is required for all items',
                'items.quantity.*.required' => 'Quantity is required and must be at least 1',
                'items.rate.*.required' => 'Rate is required and must be a positive number',
                'items.tax.*.numeric' => 'Tax must be a valid percentage',
                'items.tax.*.max' => 'Tax cannot exceed 100%',
                //'product_id.required' => 'Item is required',
                //'invoice_number.unique' => 'This invoice number is already in use by another invoice',
            ]);
        }
        try {
            $customer = Customer::find($request->customer_id);
            $lead_id  = $customer->lead_id;
            //dd($request->all());
            $invoice = $this->invoiceService->createInvoice($request->all());
            Helper::storeLog("Invoice created successfully", "Invoice", "Create Invoice",$lead_id);
            return redirect()->route('invoice-index')->with('success', 'Invoice Created Successfully!');
        } catch (\Illuminate\Database\QueryException $e) {
            if ($e->getCode() === '23000') {
                return back()->withErrors(['invoice_number' => 'This invoice number exists'])->withInput();
            }

            // Handle other database errors
            return back()->withErrors(['error' => 'There was an error creating the invoice. Please try again later.'])->withInput();
        }
    }



    public function show($id)
    {
        $invoice = Invoice::findOrFail($id);
        $invoiceItems = json_decode($invoice->item_description, true);
        //find total payment amount
        $totalPayments = 0;
        $existingPayments = $invoice->payment_details ?? [];
        //if (!empty($existingPayments)) {
        //$totalPayments = array_sum(array_column($existingPayments, 'payment'));
        //}
        //filter payments "Success" in deposit_status
        $successfulPayments = array_filter($existingPayments, function ($payment) {
            return isset($payment['deposit_status']) && $payment['deposit_status'] === 'Success';
        });

        //Sum only successful payments
        $totalPayments = array_sum(array_column($successfulPayments, 'payment'));
        //$totalPayments = array_sum(array_column($existingPayments, 'payment'));
        $newDueAmount = max(0, $invoice->total_amount - $totalPayments);
        $products = Product::select('id', 'name', 'description', 'product_value')->get();
        $customInvoiceData = InvoiceCustomForm::where('id', $invoice->invoice_custom_form_id)
                                        ->select('id', 'invoice_name','field_details','footer_details','bank_details', 'issued_by')
                                        ->first();
                                 
        return view('invoices.show', compact('invoice', 'products', 'invoiceItems','newDueAmount', 'customInvoiceData','existingPayments','totalPayments'));
    }

    public function edit($id, Request $request)
    {
        $invoice = Invoice::findOrFail($id);
        $invoiceCustomFormId = $invoice->invoice_custom_form_id;
        $invoiceItems = json_decode($invoice->item_description, true);
        $existingPayments = $invoice->payment_details ?? [];
        $totalPayments = array_sum(array_column($existingPayments, 'payment'));
        $newDueAmount = max(0, $invoice->total_amount - $totalPayments);
        //dd($invoiceItems);die();
        //dd($items);die();
        //$customers = Customer::all();
        $customers = Customer::join('leads', 'customers.lead_id', '=', 'leads.id')
        ->select('customers.*', 'leads.first_name', 'leads.last_name','leads.address')
        ->get();
        $countries = $this->countryService->countryList($request);
        $currencies = $this->currencyService->currencyList($request);
        $discountTypes = Helper::getEnumValues('invoices', 'discount_type');
        $agents = Agent::select('agent_id', 'first_name', 'last_name','user_id')->get();
        //$wordOrderNumbers = ProductSpecification::select('id', 'work_order_number')->get();
        $wordOrderNumbers = ProductSpecification::where('customer_id', $invoice->customer_id)
        ->select('id', 'work_order_number')
        ->get();

        //$products = Product::select('id', 'name', 'description', 'product_value')->get();
        $products = Product::select('id', 'name', 'description', 'product_value')->where('status', 1)->get();
        $custom_invoice = InvoiceCustomForm::select('id', 'invoice_name','field_details','footer_details')->get();
        return view('invoices.edit', compact('invoice', 'customers', 'countries', 'currencies', 'discountTypes', 'agents', 'products', 'invoiceItems','invoiceCustomFormId','custom_invoice','wordOrderNumbers','newDueAmount'));
    }


    public function update(Request $request, $id)
    {

        $validatedData = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            //'invoice_number' => 'required|unique:invoices,invoice_number,' . $id, //current invoice number
            'invoice_date' => 'required|date',
            'invoice_status' => 'required',
            'due_date' => 'nullable|date|after_or_equal:invoice_date',
        ]);

        try {
            $customer = Customer::find($request->customer_id);
            $lead_id = $customer->lead_id;
            $invoice = $this->invoiceService->updateInvoice($request->all(), $id);
            Helper::storeLog("Invoice updated successfully", "Invoice", "Edit Invoice",$lead_id);
            return redirect()->route('invoice-index')->with('success', 'Invoice Updated Successfully!');
        } catch (\Illuminate\Database\QueryException $e) {

            if ($e->getCode() === '23000') {
                return back()->withErrors(['invoice_number' => 'This invoice number exists'])->withInput();
            }

            //database errors
            return back()->withErrors(['error' => 'There was an error creating the invoice. Please try again later.'])->withInput();
        }
    }

    public function update_backup(Request $request, $id)
    {

        $validatedData = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            //'invoice_number' => 'required|unique:invoices,invoice_number,' . $id,
            'invoice_date' => 'required|date',
            'due_date' => 'nullable|date|after_or_equal:invoice_date',
            //item validation - maintaining the same structure as store
            'items.item_name.*' => 'required|string', 
            'items.quantity.*' => 'required|integer|min:1',
            'items.rate.*' => 'required|numeric|min:0',
            'items.tax.*' => 'nullable|numeric|min:0|max:100',
        ], [
            //custom error messages
            'items.item_name.*.required' => 'Item Name is required for all items',
            'items.quantity.*.required' => 'Quantity is required and must be at least 1',
            'items.rate.*.required' => 'Rate is required and must be a positive number',
            'items.tax.*.numeric' => 'Tax must be a valid percentage',
            'items.tax.*.max' => 'Tax cannot exceed 100%',
            //'invoice_number.unique' => 'This invoice number is already in use by another invoice',
        ]);

        $invoice = $this->invoiceService->updateInvoice($request->all(), $id);
        return redirect()->route('invoice-index')->with('success', 'Invoice Updated Successfully!');
    }

    public function destroy($id)
    {  
        $invoice = Invoice::find($id);
        $customerId = $invoice->customer_id;
        $lead_id = Customer::where('id', $customerId)->value('lead_id');
        Invoice::destroy($id);
        Helper::storeLog("Invoice deleted successfully", "Invoice", "Delete Invoice",$lead_id);
        return redirect()->route('invoice-index')->with('success', 'Invoice Deleted Successfully!');
    }

    // searech for invoice
    public function search(Request $request)
    {
        $searchTerm = trim($request->input('search'));

        if (empty($searchTerm)) {
            return redirect()->route('invoice-index')->with('error', 'Search field cannot be blank.');
        }

        $invoices = $this->invoiceService->searchInvoices($request);
        return view('invoices.index', compact('invoices'));
    }

    public function downloadInvoice($invoiceId)
    {

        $invoice = Invoice::join('customers', 'customers.id', '=', 'invoices.customer_id')
                            ->join('leads', 'leads.id', '=', 'customers.lead_id')
                            ->where('invoices.id', $invoiceId)
                            ->select('invoices.*', 'leads.first_name', 'leads.last_name')
                            ->first();
        $invoiceItems = json_decode($invoice->item_description, true);
        $existingPayments = $invoice->payment_details ?? [];
        //filter payments "Success" in deposit_status
        $successfulPayments = array_filter($existingPayments, function ($payment) {
            return isset($payment['deposit_status']) && $payment['deposit_status'] === 'Success';
        });

        //Sum only successful payments
        $totalPayments = array_sum(array_column($successfulPayments, 'payment'));
        //$totalPayments = array_sum(array_column($existingPayments, 'payment'));
        $newDueAmount = max(0, $invoice->total_amount - $totalPayments);
        $products = Product::select('id', 'name', 'description', 'product_value')->get();
        $customInvoiceData = InvoiceCustomForm::where('id', $invoice->invoice_custom_form_id)
                                            ->select('id', 'invoice_name','field_details','footer_details', 'bank_details', 'issued_by')
                                            ->first();
        $logogenuity = getcwd().'/uploads/invoice/genuity.png';
        $logogplex = getcwd().'/uploads/invoice/gplex.png';
        //for live url
		//$logogenuity = url('uploads/invoice/genuity.png');
        //$logogplex = url('uploads/invoice/gplex.png');
        $pdf = PDF::loadView('invoices.invoice_pdf', compact('invoice', 'products', 'invoiceItems','newDueAmount', 'customInvoiceData','logogenuity','logogplex','totalPayments'));
        return $pdf->download('invoice_' . $invoice->invoice_number . '.pdf');
    }


    public function storePayment_backup(Request $request, $invoiceId)
    {
        $request->validate([
            'payment_amount' => 'required|numeric|min:0',
        ]);

        $invoice = Invoice::findOrFail($invoiceId);
        $existingPayments = $invoice->payment_details ?? [];
        $totalPayments = array_sum(array_column($existingPayments, 'payment'));
        $newDueAmount = max(0, $invoice->total_amount - ($totalPayments + $request->input('payment_amount')));
        $paymentDetails = [
            'invoice_id' => $invoice->id,
            'payment' => $request->input('payment_amount'),
            'payment_date' => Carbon::now()->toDateString(),
            //'due' => max(0, $invoice->total_amount - $request->input('payment_amount'))
            'due' => $newDueAmount
        ];
        $this->invoiceService->addPaymentInvoice($invoice, $paymentDetails);
        return redirect()->route('invoice-index')->with('success', 'Payment recorded successfully!');
    }

    public function storePayment(Request $request, $invoiceId) {
        $invoice = Invoice::findOrFail($invoiceId);
        $customerId = $invoice->customer_id;
        $lead_id = Customer::where('id', $customerId)->value('lead_id');

        $existingPayments = $invoice->payment_details ?? [];
        $totalPayments = array_sum(array_column($existingPayments, 'payment'));
        $newDueAmount = max(0, $invoice->total_amount - $totalPayments);

        $request->validate([
            'payment_amount' => [
                'required',
                'numeric',
                'min:0',
                function ($attribute, $value, $fail) use ($newDueAmount) {
                    if ($value > $newDueAmount) {
                        $fail("The payment amount cannot exceed the due amount of $newDueAmount.");
                    }
                },
            ],
            'payment_mode'     => 'required|in:Cheque,Bank Transfer',
            'cheque_number'    => 'required_if:payment_mode,Cheque',
            'received_date'    => 'required_if:payment_mode,Cheque',
            'transfer_mode'    => 'required_if:payment_mode,Bank Transfer',
            'transfer_date'    => 'required_if:payment_mode,Bank Transfer',
            'deposit_status'   => 'required|in:Pending,Success,Failed',
            'deposit_date' => [
                'required_if:deposit_status,Success',
                'nullable',
                'date',
            ],

           
        ]);

        $paymentDetails = [
            'invoice_id'     => $invoice->id,
            'payment'        => $request->input('payment_amount'),
            'payment_mode'   => $request->input('payment_mode'),
            'cheque_number'  => $request->input('cheque_number'),
            'received_date'  => $request->input('received_date'),
            'transfer_mode'  => $request->input('transfer_mode'),
            'transfer_date'  => $request->input('transfer_date'),
            'deposit_status' => $request->input('deposit_status'),
            'deposit_date'   => $request->input('deposit_date'),
            'payment_date'   => Carbon::now()->toDateString(),
            'due'            => max(0, $newDueAmount - $request->input('payment_amount')),
        ];

        $paymentAmount = $request->input('payment_amount');
        $this->invoiceService->addPaymentInvoice($invoice, $paymentDetails, $paymentAmount);

        Helper::storeLog("Payment recorded successfully", "Invoice", "Payment recorded", $lead_id);

        return redirect()->route('invoice-index')->with('success', 'Payment recorded successfully!');
    }



    public function getWorkOrders($customerId)
    {
        $workOrders = ProductSpecification::where('customer_id', $customerId)->get(['id', 'work_order_number']);

        return response()->json($workOrders);
    }


    public function updateDepositStatus(Request $request, $invoiceId, $index)
    {
        $request->validate([
            'deposit_date' => 'required|date',
        ]);

        $invoice = Invoice::findOrFail($invoiceId);
        $payments = $invoice->payment_details ?? [];

        if (!isset($payments[$index])) {
            return back()->with('error', 'Invalid payment selected.');
        }

        $payments[$index]['deposit_date'] = $request->deposit_date;
        $payments[$index]['deposit_status'] =  'Success';

        $invoice->payment_details = $payments;
        $invoice->save();

        return redirect()->route('invoice-show', $invoice->id)->with('success', 'Deposit date updated successfully.');
    }







}
