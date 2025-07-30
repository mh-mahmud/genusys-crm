<?php

namespace App\Services;
use App\Models\Customer;
use App\Helpers\Helper;
use App\Models\Lead;
use Exception;
use Illuminate\Support\Facades\Auth;

class CustomerService
{
    public function get_customer_data($id) {

        try {
            return Lead::findOrFail($id);
        }
        catch(Exception $e) {
            return $e->getMessage();
        }
    }

    public function createCustomer($request) {

        $lead = Lead::findOrFail($request->lead_id);
        $lead->lead_rating = 10;
        $lead->save();


        $data = new Customer();
        $data->lead_id = $request->lead_id;
        $data->customer_id = $request->customer_id;
        $data->first_name = $request->first_name;
        $data->last_name = $request->last_name;
        $data->phone = $request->phone;
        $data->email = $request->email;
        if ($request->has('product_id') && is_array($request->input('product_id'))) {
            $data->product_id = implode(',', $request->input('product_id'));
        } else {
            $data->product_id = $request->product_id;
        }
        $data->created_by = Auth::user()->id;
        $data->customer_group = $request->customer_group;
        $data->customer_notes = $request->customer_notes;
        $data->customer_listing_date = $request->customer_listing_date;
        if($data->save()) {
            Helper::storeLog("Listed as a Customer ", "Customers", "Create Customer", $request->lead_id);
            return true;
        }
        return false;
    }

    public function get_all_customers() {
        //if(Auth::user()->user_type !='admin') {
            //return Customer::with('lead_data')->where('created_by', Auth::user()->id)->orderBy('created_at', 'desc')->paginate(config('constants.ROW_PER_PAGE'));
        //}
        return Customer::with('lead_data')->orderBy('created_at', 'desc')->paginate(config('constants.ROW_PER_PAGE'));
        
        // return Customer::with('lead_data')->get();
    }

    public function check_rand_string($randomString) {
        $chk = Customer::where('customer_id', $randomString)->first();
        if(is_null($chk)) {
            return false;
        }
        return true;
    }
}