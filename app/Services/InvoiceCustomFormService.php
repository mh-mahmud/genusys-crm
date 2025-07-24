<?php

namespace App\Services;

use App\Models\Invoice;
use App\Models\InvoiceCustomForm;

class InvoiceCustomFormService
{


    
    public function getAllCustomInvoice()
    {
        return InvoiceCustomForm::orderBy('created_at', 'desc')->paginate(config('constants.ROW_PER_PAGE'));
    }

    public function createCustomInvoice(array $data)
    {   
        if (isset($data['field_details']) && is_array($data['field_details'])) {
            foreach ($data['field_details'] as &$detail) {
                if (isset($detail['field_name'])) {
                    // Transform field_value: lowercase and replace spaces with underscores
                    $detail['field_value'] = strtolower(str_replace(' ', '_', $detail['field_name']));
                }
            }
        }

        //store json
        return InvoiceCustomForm::create([
            'invoice_name' => $data['invoice_name'],
            'field_details' => $data['field_details'], // direct array insertion
            // 'footer_details' => $data['footer_details'],
            'total_in_word' => $data['total_in_word'] ?? null,
            'bank_details' => $data['bank_details'] ?? null,
            'issued_by' => $data['issued_by'] ?? null,
        ]);
    }


    public function updateCustomInvoice($id, array $data)
    {
        if (isset($data['field_details']) && is_array($data['field_details'])) {
            foreach ($data['field_details'] as &$detail) {
                if (isset($detail['field_name'])) {
                    // Transform field_value: lowercase and replace spaces with underscores
                    $detail['field_value'] = strtolower(str_replace(' ', '_', $detail['field_name']));
                }
            }
        }
        $invoice = InvoiceCustomForm::findOrFail($id);
        $invoice->update([
            'invoice_name' => $data['invoice_name'],
            'field_details' => $data['field_details'],
            // 'footer_details' => $data['footer_details'],
            'total_in_word' => $data['total_in_word'] ?? null,
            'bank_details' => $data['bank_details'] ?? null,
            'issued_by' => $data['issued_by'] ?? null,
        ]);
    }


    public function searchCustomInvoice($request)
    {
        $searchTerm = trim($request->input('search'));

        return InvoiceCustomForm::where('invoice_name', 'LIKE', "%{$searchTerm}%")
        ->orderBy('created_at', 'desc')
        ->paginate(config('constants.ROW_PER_PAGE'));
    }
    

}
