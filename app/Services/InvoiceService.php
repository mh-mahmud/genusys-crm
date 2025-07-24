<?php

namespace App\Services;

use App\Models\Invoice;
use App\Models\ProductSpecification;
use App\Models\InvoiceCustomForm;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class InvoiceService
{


    public function getAllInvoices_backup()
    {
        return Invoice::orderBy('created_at', 'desc')->paginate(config('constants.ROW_PER_PAGE'));
    }

    public function getAllInvoices_21112024()
    {
        return Invoice::join('customers', 'invoices.customer_id', '=', 'customers.id')
        ->join('leads', 'customers.lead_id', '=', 'leads.id')
        ->select('invoices.*', 'customers.customer_group', 'leads.first_name', 'leads.last_name')
        ->orderBy('invoices.created_at', 'desc')
        ->paginate(config('constants.ROW_PER_PAGE'));
    }

    public function getAllInvoices_04072025()
    {
        return Invoice::join('customers', 'invoices.customer_id', '=', 'customers.id')
            ->join('leads', 'customers.lead_id', '=', 'leads.id')
            ->select('invoices.*', 'customers.customer_group', 'leads.first_name', 'leads.last_name')
            ->orderBy('invoices.created_at', 'desc')
            ->paginate(config('constants.ROW_PER_PAGE'));
    }



    public function getAllInvoices()
    {
        $userRole = DB::table('users')
            ->join('roles', 'users.role_id', '=', 'roles.id')
            ->where('users.id', Auth::id())
            ->select('roles.slug')
            ->value('slug');

        $query = Invoice::join('customers', 'invoices.customer_id', '=', 'customers.id')
            ->join('leads', 'customers.lead_id', '=', 'leads.id')
            ->select('invoices.*', 'customers.customer_group', 'leads.first_name', 'leads.last_name')
            ->orderBy('invoices.created_at', 'desc');

        if (!in_array($userRole, ['business_development', 'super_admin', 'marketing_user'])) {
            $query->where('invoices.approval_status', 'approved');
        }

        return $query->paginate(config('constants.ROW_PER_PAGE'));
    }


    public function getAllPendingInvoices()
    {
        return Invoice::join('customers', 'invoices.customer_id', '=', 'customers.id')
        ->join('leads', 'customers.lead_id', '=', 'leads.id')
        ->where('invoices.approval_status', '!=', 'approved')
        ->select('invoices.*', 'customers.customer_group', 'leads.first_name', 'leads.last_name')
        ->orderBy('invoices.created_at', 'desc')
        ->paginate(config('constants.ROW_PER_PAGE'));
    }





    public function createInvoice($data)
    {
        //prepare items array by iterating
        //dd($data);
        $items = [];
        if(empty($data["custom_invoice_id"])) {
            $itemCount = count($data['items']['item_name']); //all arrays have the same length

            for ($i = 0; $i < $itemCount; $i++) {
                $items[] = [
                    'Item' => $data['items']['item_name'][$i] ?? '',
                    'Description' => $data['items']['descriptions'][$i] ?? '',
                    'Qty' => $data['items']['quantity'][$i] ?? 0,
                    'Rate' => $data['items']['rate'][$i] ?? 0,
                    'Tax' => $data['items']['tax'][$i] ?? 0,
                    'Amount' => ($data['items']['quantity'][$i] ?? 0) * ($data['items']['rate'][$i] ?? 0) //calculate Amount (Qty * Rate)
                ];
            }
        } else {
            $custom_form = InvoiceCustomForm::where('id', $data["custom_invoice_id"])
                                ->select('field_details', 'footer_details')
                                ->first();
            //dd($custom_form);die();
            
            foreach ($custom_form->field_details as $custom_form_data) {
                $fieldName = $custom_form_data["field_value"];           
                if (array_key_exists($fieldName, $data['items'])) {
                    foreach ($data['items'][$fieldName] as $key => $value) {
                        if (!empty($value)) {
                            $items[$key][] = [$fieldName => $value];
                        }
                    }
                }
            } 
            if(!empty($data['items']['amount'])) {
                foreach($data['items']['amount'] as $key => $amount) {
                    $items[$key][] = ["amount" => $amount];
                }
            }
            // foreach ($custom_form->footer_details as $custom_footer_data) {
            //     $footerName = $custom_footer_data["field_value"];           
            //     if (array_key_exists($footerName, $data['footer'])) {                 
            //         $custom_footer = [$footerName => $data['footer'][$footerName]];
            //     }
            // }    
        }
        //array as JSON
        $itemDescriptionJson = json_encode($items);
        // $customFooterJson = json_encode($custom_footer);

        //create the invoice
        $invoice = Invoice::create([
            'invoice_number' =>  'INV-' . $data['invoice_number'],
            'ref_no' => $data['ref_no'],
            'customer_id' => $data['customer_id'],
            'invoice_custom_form_id' => $data["custom_invoice_id"],
            'ps_id' => $data["ps_id"],
            'address' => $data['address'],
            'invoice_date' => $data['invoice_date'],
            'due_date' => $data['due_date'],
            'total_amount' => $data['total_amount'],
            'vat' => $data['vat'],

            'total_tax' => $data['total_tax'],
            'sub_total' => $data['sub_total'],
            'discount' => $data['total_discount'],
            'discount_type' => $data['discount_type_name'],
            'admin_note' => $data['admin_note'],
            'client_note' => $data['client_note'],
            'terms_conditions' => $data['terms_conditions'],
            //'adjustment' => $data['custom_adjustment'] ? $data['custom_adjustment'] : $data['adjustment'],
            'adjustment' => $data['custom_adjustment'] ?? $data['adjustment'] ?? null,
            'currency' => $data['currency'],
            'payment_mode' => $data['payment_mode'],
            'sale_agent_id' => $data['sale_agent_id']?? $data['sale_agent_id'] ?? null,
            'created_by' =>Auth::user()->id,
            'invoice_status' => $data['invoice_status']?? null,
            'item_description' => $itemDescriptionJson,
            // 'custom_footer_details' => $customFooterJson,
        ]);

        return $invoice;
    }



    public function updateInvoice_19122024(array $data, $id)
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
        $invoice->created_by = Auth::user()->id;
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


    public function updateInvoice(array $data, $id)
    {
        $invoice = Invoice::findOrFail($id);

        //update details invoice general details
        $invoice->invoice_number = 'INV-' . $data['invoice_number'];
        $invoice->ref_no = $data['ref_no'];
        $invoice->customer_id = $data['customer_id'];
        $invoice->invoice_custom_form_id = $data['custom_invoice_id'] ?? null;
        $invoice->ps_id = $data['ps_id'] ?? null;
        $invoice->address = $data['address'];
        $invoice->invoice_date = $data['invoice_date'];
        $invoice->due_date = $data['due_date'];
        $invoice->sub_total = $data['sub_total'];
        $invoice->total_amount = $data['total_amount'];
        $invoice->vat = $data['vat']?? null;
        $invoice->total_tax = $data['total_tax'] ?? null;
        $invoice->discount = $data['total_discount'] ?? null;
        $invoice->discount_type = $data['discount_type_name'] ?? null;
        //$invoice->adjustment = $data['custom_adjustment'] ? $data['custom_adjustment'] : $data['adjustment'];
        $invoice->adjustment = $data['custom_adjustment'] ?? $data['adjustment'] ?? null;
        $invoice->admin_note = $data['admin_note'];
        $invoice->client_note = $data['client_note'];
        $invoice->terms_conditions = $data['terms_conditions'];
        $invoice->currency = $data['currency'];
        $invoice->payment_mode = $data['payment_mode'];
        $invoice->sale_agent_id = $data['sale_agent_id']?? $data['sale_agent_id'] ?? null;
        $invoice->created_by = Auth::user()->id;
        $invoice->invoice_status = $data['invoice_status']?? null;

        //handle item description logic
        $items = [];
        if (empty($data["custom_invoice_id"])) {
            // default invoice items
            foreach ($data['items']['item_name'] as $key => $itemName) {
                if (!empty($itemName) || !empty($data['items']['descriptions'][$key]) || !empty($data['items']['quantity'][$key]) || !empty($data['items']['rate'][$key])) {
                    $items[] = [
                        'Item' => $itemName,
                        'Description' => $data['items']['descriptions'][$key] ?? '',
                        'Qty' => $data['items']['quantity'][$key] ?? 0,
                        'Rate' => $data['items']['rate'][$key] ?? 0,
                        'Tax' => $data['items']['tax'][$key] ?? 0,
                        'Amount' => ($data['items']['quantity'][$key] ?? 0) * ($data['items']['rate'][$key] ?? 0),
                    ];
                }
            }
        } else {
            //custom invoice items
            $custom_form = InvoiceCustomForm::where('id', $data["custom_invoice_id"])
            ->select('field_details', 'footer_details')
            ->first();

            foreach ($custom_form->field_details as $custom_form_data) {
                $fieldName = $custom_form_data["field_value"];
                if (array_key_exists($fieldName, $data['items'])) {
                    foreach ($data['items'][$fieldName] as $key => $value) {
                        if (!empty($value)) {
                            $items[$key][] = [$fieldName => $value];
                        }
                    }
                }
            }
            if (!empty($data['items']['amount'])) {
                foreach ($data['items']['amount'] as $key => $amount) {
                    $items[$key][] = ["amount" => $amount];
                }
            }

            $items = array_filter($items, function ($row) {
                // chk if the row has any non-empty fields
                foreach ($row as $field) {
                    if (!empty(array_values($field)[0])) {
                        return true;
                    }
                }
                return false;
            });
        }
       
        // array to JSON and save
        $invoice->item_description = json_encode($items);
        //dd($invoice->item_description);die();
        $invoice->save();
    }



    public function searchInvoices_backup($request)
    {
        $searchTerm = trim($request->input('search'));

        return Invoice::where('invoice_number', 'LIKE', "%{$searchTerm}%")
            ->orWhere('invoice_date', 'LIKE', "%{$searchTerm}%")
            ->orWhere('due_date', 'LIKE', "%{$searchTerm}%")
            ->orderBy('created_at', 'desc')
            ->paginate(config('constants.ROW_PER_PAGE'));
    }

    public function searchInvoices($request)
    {
        $searchTerm = trim($request->input('search'));
    
        //convert search DD-MM-YYYY to YYYY-MM-DD if date
        $formattedSearchTerm = preg_match('/\d{2}-\d{2}-\d{4}/', $searchTerm) 
            ? Carbon::createFromFormat('d-m-Y', $searchTerm)->format('Y-m-d') 
            : $searchTerm;
    
        return Invoice::join('customers', 'invoices.customer_id', '=', 'customers.id')
            ->join('leads', 'customers.lead_id', '=', 'leads.id')
            ->where(function ($query) use ($formattedSearchTerm) {
                $query->where('invoices.invoice_number', 'LIKE', "%{$formattedSearchTerm}%")
                    ->orWhereRaw("DATE_FORMAT(invoices.invoice_date, '%Y-%m-%d') LIKE ?", ["%{$formattedSearchTerm}%"])
                    ->orWhereRaw("DATE_FORMAT(invoices.due_date, '%Y-%m-%d') LIKE ?", ["%{$formattedSearchTerm}%"])
                    ->orWhere('customers.customer_group', 'LIKE', "%{$formattedSearchTerm}%")
                    ->orWhere('leads.first_name', 'LIKE', "%{$formattedSearchTerm}%")
                    ->orWhere('leads.last_name', 'LIKE', "%{$formattedSearchTerm}%");
            })
            ->select('invoices.*', 'customers.customer_group', 'leads.first_name', 'leads.last_name')
            ->orderBy('invoices.created_at', 'desc')
            ->paginate(config('constants.ROW_PER_PAGE'));
    }
    
    
    


    public function addPaymentInvoice_backup($invoice, $paymentDetails,$payment_amount)
    {
        $existingPayments = $invoice->payment_details ?? [];
        $existingPayments[] = $paymentDetails;
        $invoice->payment_details = $existingPayments;
        $invoice->save();
        //update product specification data
        $pr_sp = ProductSpecification::findOrFail($invoice->ps_id);
        $pr_sp->remaining_month = $pr_sp->remaining_month - 1; 
        $pr_sp->due_balance = $pr_sp->due_balance - $payment_amount;
        $pr_sp->save();
        return $invoice;
    }

    public function addPaymentInvoice($invoice, $paymentDetails,$payment_amount)
    {
        $existingPayments = $invoice->payment_details ?? [];
        $existingPayments[] = $paymentDetails;
        $invoice->payment_details = $existingPayments;
        $invoice->save();
        //update product specification data
        if (!empty($invoice->ps_id)) {
            $pr_sp = ProductSpecification::find($invoice->ps_id); 
    
            if ($pr_sp) { 
                $pr_sp->remaining_month = max(0, $pr_sp->remaining_month - 1); 
                $pr_sp->due_balance = max(0, $pr_sp->due_balance - $payment_amount);
                $pr_sp->save();
            }
        }
    }
    
}
