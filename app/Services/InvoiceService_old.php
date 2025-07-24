<?php

namespace App\Services;

use App\Models\Invoice;

class InvoiceService
{


    public function getAllInvoices_backup()
    {
        return Invoice::orderBy('created_at', 'desc')->paginate(config('constants.ROW_PER_PAGE'));
    }

    public function getAllInvoices()
    {
        return Invoice::join('customers', 'invoices.customer_id', '=', 'customers.id')
        ->join('leads', 'customers.lead_id', '=', 'leads.id')
        ->select('invoices.*', 'customers.customer_group', 'leads.first_name', 'leads.last_name')
        ->orderBy('invoices.created_at', 'desc')
        ->paginate(config('constants.ROW_PER_PAGE'));
    }



    public function createInvoice($data)
    {
        //prepare items array by iterating
        //dd($data);die();
        $items = [];
        $itemCount = count($data['items']['item_name']); //all arrays have the same length

        for ($i = 0; $i < $itemCount; $i++) {
            $items[] = [
                'Item' => $data['items']['item_name'][$i] ?? '',
                'Description' => $data['items']['description'][$i] ?? '',
                'Qty' => $data['items']['quantity'][$i] ?? 0,
                'Rate' => $data['items']['rate'][$i] ?? 0,
                'Tax' => $data['items']['tax'][$i] ?? 0,
                'Amount' => ($data['items']['quantity'][$i] ?? 0) * ($data['items']['rate'][$i] ?? 0) //calculate Amount (Qty * Rate)
            ];
        }
        //array as JSON
        $itemDescriptionJson = json_encode($items);
        //create the invoice
        $invoice = Invoice::create([
            'invoice_number' =>  'INV-' . $data['invoice_number'],
            'customer_id' => $data['customer_id'],
            'address' => $data['address'],
            'invoice_date' => $data['invoice_date'],
            'due_date' => $data['due_date'],
            'total_amount' => $data['total_amount'],
            'total_tax' => $data['total_tax'],
            'sub_total' => $data['sub_total'],
            'discount' => $data['total_discount'],
            'discount_type' => $data['discount_type_name'],
            'admin_note' => $data['admin_note'],
            'client_note' => $data['client_note'],
            'terms_conditions' => $data['terms_conditions'],
            'adjustment' => $data['adjustment'],
            'currency' => $data['currency'],
            'payment_mode' => $data['payment_mode'],
            'sale_agent_id' => $data['sale_agent_id'],
            'invoice_status' => $data['invoice_status'],
            'item_description' => $itemDescriptionJson,
        ]);

        return $invoice;
    }



    public function updateInvoice(array $data, $id)
    {
        $invoice = Invoice::findOrFail($id);
        //dd($data);die();
        $invoice->invoice_number = 'INV-' . $data['invoice_number'];
        $invoice->customer_id = $data['customer_id'];
        $invoice->address = $data['address'];
        $invoice->invoice_date = $data['invoice_date'];
        $invoice->due_date = $data['due_date'];
        $invoice->sub_total = $data['sub_total'];
        $invoice->total_amount = $data['total_amount'];
        $invoice->total_tax = $data['total_tax'] ?? null;
        $invoice->discount = $data['total_discount'] ?? null;
        $invoice->discount_type = $data['discount_type_name'] ?? null;
        $invoice->adjustment = $data['adjustment'] ?? null;
        $invoice->admin_note = $data['admin_note'];
        $invoice->client_note = $data['client_note'];
        $invoice->terms_conditions = $data['terms_conditions'];
        $invoice->currency = $data['currency'];
        $invoice->payment_mode = $data['payment_mode'];
        $invoice->sale_agent_id = $data['sale_agent_id'];
        $invoice->invoice_status = $data['invoice_status'];
        //saved as json, excluding empty rows
        $items = [];
        foreach ($data['items']['item_name'] as $key => $itemName) {
            //chk if any relevant field for the item is filled out
            if (!empty($itemName) || !empty($data['items']['description'][$key]) || !empty($data['items']['quantity'][$key]) || !empty($data['items']['rate'][$key])) {
                $items[] = [
                    'Item' => $itemName,
                    'Description' => $data['items']['description'][$key] ?? '',
                    'Qty' => $data['items']['quantity'][$key] ?? 0,
                    'Rate' => $data['items']['rate'][$key] ?? 0,
                    'Tax' => $data['items']['tax'][$key] ?? 0,
                    'Amount' => ($data['items']['quantity'][$key] ?? 0) * ($data['items']['rate'][$key] ?? 0),
                ];
            }
        }

        //array to JSON
        $invoice->item_description = json_encode($items);
        $invoice->save();
    }


    public function searchInvoices($request)
    {
        $searchTerm = trim($request->input('search'));

        return Invoice::where('invoice_number', 'LIKE', "%{$searchTerm}%")
            ->orWhere('invoice_date', 'LIKE', "%{$searchTerm}%")
            ->orWhere('due_date', 'LIKE', "%{$searchTerm}%")
            ->orderBy('created_at', 'desc')
            ->paginate(config('constants.ROW_PER_PAGE'));
    }

    public function addPaymentInvoice($invoice, $paymentDetails)
    {
        //directly push to the array if it's already cast
        $existingPayments = $invoice->payment_details ?? [];
        $existingPayments[] = $paymentDetails;
        $invoice->payment_details = $existingPayments;
        $invoice->save();
        return $invoice;
    }
    
}
