<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\InvoiceCustomFormService;
use App\Models\InvoiceCustomForm;

class InvoiceCustomFormController extends Controller
{
    protected $invoiceCustomFormService;

    public function __construct(InvoiceCustomFormService $invoiceCustomFormService)
    {
        $this->invoiceCustomFormService = $invoiceCustomFormService;
    }

    public function index()
    {
        //$invoices = Invoice::all();
        $invoices = $this->invoiceCustomFormService->getAllCustomInvoice();
        return view('invoice_custom.index', compact('invoices'));
    }
    public function create()
    {
        return view('invoice_custom.create');
    }

    public function store(Request $request)
    {  
        $data = $request->validate([
            'invoice_name' => 'required|string|max:255',
            'field_details' => 'array',
            'field_details.*.field_name' => 'required|string',
            'field_details.*.is_sum' => 'required',
            'field_details.*.is_mandatory' => 'required',
            'total_in_word' => 'nullable|string|max:255',
            'bank_details' => 'nullable|string',
            'issued_by' => 'nullable|string',
        ], [
            //custom error messages
            'field_details.*.field_name.required' => 'Each Item Field Name is required.',
            'field_details.*.field_value.required' => 'Each Item Field Value is required.',
            'field_details.*.is_sum.required' => 'Is Sum is required.',
            'field_details.*.is_mandatory.required' => 'Is Mandatory Field Value is required.',
            'invoice_name.required' => 'The Invoice Name is required.',
            'total_in_word.max' => 'The Total in Words field should not exceed 255 characters.',
        ]);
        $this->invoiceCustomFormService->createCustomInvoice($data);

        return redirect()->route('invoice-custom-index')->with('success', 'Custom Invoice created successfully.');
    }

    
    public function show($id)
    {
        $invoice = InvoiceCustomForm::findOrFail($id);
        //directly access field_details as an array and show field name
        $fieldNames = collect($invoice->field_details)->pluck('field_name')->implode(', ');
        $footerFieldNames = collect($invoice->footer_details)->pluck('field_name')->implode(', ');
        return view('invoice_custom.show', compact('invoice','fieldNames','footerFieldNames'));
    }


    public function edit($id)
    {
        $invoice = InvoiceCustomForm::findOrFail($id);
        return view('invoice_custom.edit', compact('invoice'));
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'invoice_name' => 'required|string|max:255',
            'field_details' => 'array',
            'field_details.*.field_name' => 'required|string',
            'total_in_word' => 'nullable|string|max:255',
            'bank_details' => 'nullable|string',
            'issued_by' => 'nullable|string',
        ], [
            'field_details.*.field_name.required' => 'Each Item Field Name is required.',
            'invoice_name.required' => 'The Invoice Name is required.',
            'total_in_word.max' => 'The Total in Words field should not exceed 255 characters.',
        ]);
        //$this->leadsFormService->updateLeadsForm($id, $request->all());
        $this->invoiceCustomFormService->updateCustomInvoice($id, $request->all());

        return redirect()->route('invoice-custom-index')->with('success', 'Custom Invoice updated successfully.');
    }


    public function destroy($id)
    {
        InvoiceCustomForm::destroy($id);
        return redirect()->route('invoice-custom-index')->with('success', 'Custom Invoice Deleted Successfully!');
    }

    // searech for invoice
    public function search(Request $request)
    {
        $searchTerm = trim($request->input('search'));

        if (empty($searchTerm)) {
            return redirect()->route('invoice-custom-index')->with('error', 'Search field cannot be blank.');
        }

        $invoices = $this->invoiceCustomFormService->searchCustomInvoice($request);
        return view('invoice_custom.index', compact('invoices'));
    }

}
