<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Services\API\LeadService;
use App\Models\Leads;
use Illuminate\Support\Facades\Validator; 
use App\Models\ApiUser;

class LeadController extends Controller
{

    protected $lead_service;
    public function __construct(LeadService $lead_service) {
        $this->lead_service = $lead_service;
    }

    public function uploadLeads_backup(Request $request)
    {
        // Check username and password first
        if ($request->username !== 'gplex_crm' || $request->password !== 'GLXS_OKTaYHRs@6') {
            return response()->json([
                'status_code' => 400,
                'status_message' => 'Failed',
                'message' => 'Invalid username or password',
                'errors' => ['Invalid username or password'],
            ], 400);
        }

        // Validate the request
        $validator = Validator::make($request->all(), [
            'username' => 'required|string',
            'password' => 'required|string',
            'requestTimestamp' => 'required|integer',
            'requestType' => 'required|string',
            'leads' => 'required|array',
            'leads.*.email' => 'nullable|string|email|max:191|unique:leads,email',
            'leads.*.phone' => 'required|string|max:191',
        ]);

        // Check if validation fails
        if ($validator->fails()) {
            return response()->json([
                'status_code' => 400,
                'status_message' => 'Validation Failed',
                'message' => 'Validation errors occurred.',
                'errors' => $validator->errors(),
            ], 400);
        }

        // Process the request if validation passes
        $result = $this->lead_service->uploadLeads($request->all());

        if ($result['status']) {
            return response()->json([
                'status_code' => 200,
                'status_message' => 'Success',
                'message' => 'Leads uploaded successfully'
            ], 200);
        } else {
            return response()->json([
                'status_code' => 400,
                'status_message' => 'Failed',
                'message' => 'Failed to upload leads',
                'errors' => $result['errors']
            ], 400);
        }
    }

    public function uploadLeads(Request $request)
    {
        $currentTimestamp = time();
        $headers = apache_request_headers();

        $response = [
            'result'            => false,
            'responseTimestamp' => $currentTimestamp,
            'resultCode'        => 406,
            'request_param'     => $request->all(),
            'message'           => ["Invalid header request!"],
        ];

        if ($request->isJson() && isset($headers['keyHash']) && !empty($headers['keyHash'])) {
            $keyHash = trim($headers['keyHash']);
            $authInfo = $this->getApiUser($request->username);

            if (!empty($authInfo) && md5($authInfo['username'] . ":" . $authInfo['password'] . ":" . $request->requestTimestamp) == $keyHash
                && (abs($currentTimestamp - $request->requestTimestamp) <= 1200)) {

                // Validate the request
                $validator = Validator::make($request->all(), [
                    'username' => 'required|string',
                    'password' => 'required|string',
                    'requestTimestamp' => 'required|integer',
                    'requestType' => 'required|string',
                    'leads' => 'required|array',
                    'leads.*.email' => 'nullable|string|email|max:191|unique:leads,email',
                    'leads.*.phone' => 'required|string|max:191',
                ]);

                if ($validator->fails()) {
                    return response()->json([
                        'status_code' => 400,
                        'status_message' => 'Validation Failed',
                        'message' => 'Validation errors occurred.',
                        'errors' => $validator->errors(),
                    ], 400);
                }

                $result = $this->lead_service->uploadLeads($request->all());

                if ($result['status']) {
                    return response()->json([
                        'status_code' => 200,
                        'status_message' => 'Success',
                        'message' => 'Leads uploaded successfully'
                    ], 200);
                } else {
                    return response()->json([
                        'status_code' => 400,
                        'status_message' => 'Failed',
                        'message' => 'Failed to upload leads',
                        'errors' => $result['errors']
                    ], 400);
                }
            } else {
                $response = [
                    'result' => false,
                    'responseTimestamp' => $currentTimestamp,
                    'resultCode' => 401,
                    'message' => ["Authentication failed!"],
                ];
            }
        }

        return response()->json($response, $response['resultCode']);
    }

    private function getApiUser($username)
    {
        return ApiUser::where('username', $username)->first();
    }
    
}
