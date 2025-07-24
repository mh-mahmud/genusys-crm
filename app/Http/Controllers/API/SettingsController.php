<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Services\API\SettingsService;
use App\Models\Country;
use App\Models\State;
use App\Models\Branch;

class SettingsController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    protected $settings_service;
    public function __construct(SettingsService $settings_service) {
        $this->settings_service = $settings_service;
    }

    /*
        Country Settings
    */
    public function country_index()
    {
        return Country::all();
    }

    public function country_store(Request $request)
    {
        $request->validate([
            'country_name' => 'required|unique:country'
        ]);
        return Country::create($request->all());
    }

    public function country_show(string $id)
    {
        return Country::find($id);
    }

    public function country_update(Request $request, string $id)
    {
        $country = Country::find($id);
        $country->update($request->all());
        return $country;
    }

    public function country_destroy(string $id)
    {
        return Country::destroy($id);
    }


    /*
        State Settings
    */

    public function state_index()
    {
        return State::all();
    }

    public function state_store(Request $request)
    {
        $request->validate([
            'state_name' => 'required',
            'country_id' => 'required'
        ]);

        $ckh_dub = State::where('state_name', $request->state_name)->where('country_id', $request->country_id)->first();
        if(!empty($ckh_dub)) {
            $status = "dublicate";
            $msg=["this state already created"];
            $data=[];
            return response()->json(compact('status', 'msg', 'data'))->setStatusCode(200);
        }


        $data = State::create($request->all());
        $status = "success";
        $msg=["State saved successfully"];
        return response()->json(compact('status', 'msg', 'data'))->setStatusCode(200);
    }

    public function state_show(string $id)
    {
        $data = State::find($id);
        if(!empty($data)) {
            $status = "success";
            $msg=["data found"];
            return response()->json(compact('status', 'msg', 'data'))->setStatusCode(200);
        }
        $status = "failed";
        $msg=["no data found"];
        return response()->json(compact('status', 'msg', 'data'))->setStatusCode(401);
    }

    public function state_update(Request $request)
    {
        $request->validate([
            'id' => 'required'
        ]);

        $ticket_data = State::find($request->id);
        if(!empty($ticket_data)) {
            $ticket_data->update($request->all());
            $status = "success";
            $msg=["State updated successfully"];
            return response()->json(compact('status', 'msg', 'ticket_data'))->setStatusCode(200);
        }

        $status = "failed";
        $msg=["no data found"];
        return response()->json(compact('status', 'msg', 'data'))->setStatusCode(401);
    }

    public function state_destroy(Request $request)
    {
        $data = [];
        $request->validate([
            'id' => 'required'
        ]);

        $check = State::find($request->id);
        if(!empty($check)) {
            $data['data'] = State::destroy($request->id);
            $data['status'] = "success";
            $data['msg'] = ["State deleted successfully"];
            return response()->json(compact('data'))->setStatusCode(200);
        }
        $data['status'] = "failed";
        $data['msg']= ["no data found"];
        return response()->json(compact('data'))->setStatusCode(401);
    }


    /*
        City Settings
    */
    public function city_index()
    {
        return City::all();
    }

    public function city_store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'country_id' => 'required',
            'state_id' => 'required'
        ]);
        return City::create($request->all());
    }

    public function city_show(string $id)
    {
        return City::find($id);
    }

    public function city_update(Request $request, string $id)
    {
        $city = City::find($id);
        $city->update($request->all());
        return $city;
    }

    public function city_destroy(string $id)
    {
        return City::destroy($id);
    }


    /*
        Branch Settings
    */
        
    public function branch_index()
    {
        return Branch::all();
    }

    public function branch_store(Request $request)
    {
        $data = [];
        $request->validate([
            'branch_name' => 'required',
            'branch_code' => 'required',
            'status' => 'required'
        ]);

        $ckh_dub = Branch::where('branch_name', $request->branch_name)->where('branch_code', $request->branch_code)->first();
        if(!empty($ckh_dub)) {
            $data['status'] = "dublicate";
            $data['msg']=["this branch already created"];
            return response()->json(compact('data'))->setStatusCode(200);
        }

        $data['data'] = Branch::create($request->all());
        $data['status'] = "success";
        $data['msg']=["Branch saved successfully"];
        return response()->json(compact('data'))->setStatusCode(200);
    }

    public function branch_show(string $id)
    {
        $data = [];
        $chk_data = Branch::find($id);
        if(!empty($chk_data)) {
            $status = "success";
            $msg=["data found"];
            $data['data'] = $chk_data;
            return response()->json(compact('data'))->setStatusCode(200);
        }
        $data['status'] = "failed";
        $data['msg']=["no data found"];
        return response()->json(compact('data'))->setStatusCode(401);
    }

    public function branch_update(Request $request)
    {
        $data = [];
        $request->validate([
            'id' => 'required'
        ]);

        $branch_data = Branch::find($request->id);
        if(!empty($branch_data)) {
            $branch_data->update($request->all());
            $data['status'] = "success";
            $data['msg']=["Branch updated successfully"];
            $data['data'] = $branch_data;
            return response()->json(compact('data'))->setStatusCode(200);
        }

        $data['status'] = "failed";
        $data['msg']=["no data found"];
        return response()->json(compact('data'))->setStatusCode(401);
    }

    public function branch_destroy(Request $request)
    {
        $data = [];
        $request->validate([
            'id' => 'required'
        ]);

        $check = Branch::find($request->id);
        if(!empty($check)) {
            $data['data'] = Branch::destroy($request->id);
            $data['status'] = "success";
            $data['msg'] = ["Branch deleted successfully"];
            return response()->json(compact('data'))->setStatusCode(200);
        }
        $data['status'] = "failed";
        $data['msg']= ["no data found"];
        return response()->json(compact('data'))->setStatusCode(401);
    }


}
