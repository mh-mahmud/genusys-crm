<?php
namespace App\Services\API;

use App\Models\Product;
use App\Models\City;
use App\Models\Leads;
use App\Models\LeadFormDetail;
use App\Models\LeadsForm;

class LeadsService {

	public function getAllLeadsForm() {
		return LeadsForm::where('id', '=', 3)->get();
	}

	public function getLeadsFormById($id) {
		return LeadsForm::where('id', '=', $id)->first();
	}

	public function updateLeadsFormById($request) {
        $chk_data = LeadsForm::find($request->id);

        if(!empty($chk_data)) {
            $chk_data->update($request->all());
            $data['status'] = "success";
            $data['msg']= "form data updated successfully";
            $data['data'] = $chk_data;
            return response()->json(compact('data'))->setStatusCode(200);
        }

        $data['status'] = "failed";
        $data['msg']=["no data found"];
        return response()->json(compact('data'))->setStatusCode(401);
	}

	public function storeFormData($request) {
		$characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$rand_str = substr(str_shuffle($characters), 0, 10);

        try{

            $data = new LeadsForm();
            $data->form_id = $rand_str;
            $data->parent_id = !empty($request->parent_id) ? $request->parent_id : null;
            $data->form_name = $request->form_name;
            $data->form_description = $request->form_description;
            $data->form_status = !empty($request->form_status) ? $request->form_status : 1;
            $data->save();
            return response()->json(['status'=> 'success', 'message' => 'Form request submitted successfully']);

        }catch(\Exception $e){
            return response()->json(['status'=>'error', 'message' => $e->getMessage()], 401);
        }
	}

}