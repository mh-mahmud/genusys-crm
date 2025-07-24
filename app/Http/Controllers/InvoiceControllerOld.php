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
use Carbon\Carbon;
use PDF;
use Illuminate\Support\Facades\Auth;

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
        $invoices = $this->invoiceService->getAllInvoices();
        return view('invoices.index', compact('invoices'));
    }

    public function create(Request $request)
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
        $custom_invoice = InvoiceCustomForm::select('id', 'invoice_name','field_details')->get();
        $products = Product::select('id', 'name', 'description', 'product_value')->get();
        return view('invoices.create', compact('customers', 'countries', 'currencies', 'nextInvoiceNumber', 'discountTypes', 'agents', 'products','custom_invoice'));
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

        $validatedData = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            //'invoice_number' => 'required|unique:invoices,invoice_number',
            'invoice_date' => 'required|date',
            'due_date' => 'nullable|date|after_or_equal:invoice_date',
            'product_id' => 'required|exists:products,id',
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
            'product_id.required' => 'Item is required',
            //'invoice_number.unique' => 'This invoice number is already in use by another invoice',
        ]);
        try {

            $invoice = $this->invoiceService->createInvoice($request->all());
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
        $existingPayments = $invoice->payment_details ?? [];
        $totalPayments = array_sum(array_column($existingPayments, 'payment'));
        $newDueAmount = max(0, $invoice->total_amount - $totalPayments);
        $products = Product::select('id', 'name', 'description', 'product_value')->get();
        return view('invoices.show', compact('invoice', 'products', 'invoiceItems','newDueAmount'));
    }

    public function edit($id, Request $request)
    {
        $invoice = Invoice::findOrFail($id);
        $invoiceItems = json_decode($invoice->item_description, true);
        //dd($items);die();
        //$customers = Customer::all();
        $customers = Customer::join('leads', 'customers.lead_id', '=', 'leads.id')
        ->select('customers.*', 'leads.first_name', 'leads.last_name')
        ->get();
        $countries = $this->countryService->countryList($request);
        $currencies = $this->currencyService->currencyList($request);
        $discountTypes = Helper::getEnumValues('invoices', 'discount_type');
        $agents = Agent::select('agent_id', 'first_name', 'last_name','user_id')->get();
        $products = Product::select('id', 'name', 'description', 'product_value')->get();
        return view('invoices.edit', compact('invoice', 'customers', 'countries', 'currencies', 'discountTypes', 'agents', 'products', 'invoiceItems'));
    }


    public function update(Request $request, $id)
    {

        $validatedData = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            //'invoice_number' => 'required|unique:invoices,invoice_number,' . $id, //current invoice number
            'invoice_date' => 'required|date',
            'due_date' => 'nullable|date|after_or_equal:invoice_date',
        ]);

        try {
            $invoice = $this->invoiceService->updateInvoice($request->all(), $id);
            return redirect()->route('invoice-index')->with('success', 'Invoice Updated Successfully!');
        } catch (\Illuminate\Database\QueryException $e) {

            if ($e->getCode() === '23000') {
                return back()->withErrors(['invoice_number' => 'This invoice number exists'])->withInput();
            }

            // Handle other database errors
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
        Invoice::destroy($id);
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

        $invoice = Invoice::findOrFail($invoiceId);
        $invoiceItems = json_decode($invoice->item_description, true);
        $existingPayments = $invoice->payment_details ?? [];
        $totalPayments = array_sum(array_column($existingPayments, 'payment'));
        $newDueAmount = max(0, $invoice->total_amount - $totalPayments);
        $products = Product::select('id', 'name', 'description', 'product_value')->get();
        $pdf = PDF::loadView('invoices.invoice_pdf', compact('invoice', 'products', 'invoiceItems','newDueAmount'));
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

    public function storePayment(Request $request, $invoiceId)
    {
        $invoice = Invoice::findOrFail($invoiceId);
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
        ]);

        $paymentDetails = [
            'invoice_id' => $invoice->id,
            'payment' => $request->input('payment_amount'),
            'payment_date' => Carbon::now()->toDateString(),
            'due' => max(0, $newDueAmount - $request->input('payment_amount'))
        ];

        $this->invoiceService->addPaymentInvoice($invoice, $paymentDetails);

        return redirect()->route('invoice-index')->with('success', 'Payment recorded successfully!');
    }

}
