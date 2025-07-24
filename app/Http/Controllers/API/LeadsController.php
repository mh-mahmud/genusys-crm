<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Services\API\LeadsService;
use App\Models\LeadsForm;
use App\Models\LeadFormDetail;
use App\Models\Leads;

class LeadsController extends Controller
{

    protected $lead_service;
    public function __construct(LeadsService $lead_service) {
        $this->lead_service = $lead_service;
    }

    public function index()
    {
        $result = $this->lead_service->getAllLeadsForm();
        if($result->isNotEmpty()) {
            $data['status'] = "success";
            $data['msg'] = "leads data found";
            $data['data'] = $result;
            return response()->json(compact('data'))->setStatusCode(200);
        }

        $data['status'] = "failed";
        $data['msg'] = "no data found";
        $data['data'] = !empty($result) ? $result : null;
        return response()->json(compact('data'))->setStatusCode(401);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $request->validate([
            'form_name' => 'required',
            'form_description' => 'required',
        ]);

        return $this->lead_service->storeFormData($request);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $result = $this->lead_service->getLeadsFormById($id);

        if(!empty($result)) {
            $data['status'] = "success";
            $data['msg'] = "leads data found";
            $data['data'] = $result;
            return response()->json(compact('data'))->setStatusCode(200);
        }

        $data['status'] = "failed";
        $data['msg'] = "no data found";
        $data['data'] = !empty($result) ? $result : null;
        return response()->json(compact('data'))->setStatusCode(401);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $data = [];
        $request->validate([
            'id' => 'required'
        ]);

        return $this->lead_service->updateLeadsFormById($request);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        return "This is delete action";
    }
}
