<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Services\API\SmsService;
use App\Models\SmsTemplate;
use App\Models\SmsQueue;
use App\Models\SmsLog;

class SmsController extends Controller
{
    protected $service;
    public function __construct(SmsService $sms_service) {
    	$this->service = $sms_service;
    }

    /*
        SMS Templates
    */
        
    public function sms_template_list()
    {
        return $this->service->get_all_templates();
    }

    public function sms_template_create(Request $request)
    {
        return $this->service->sms_template_create_service($request);
    }

    public function sms_template_show(string $id)
    {
        return $this->service->sms_template_show_service($id);
    }

    public function sms_template_update(Request $request)
    {
        return $this->service->sms_template_update_service($request);
    }

    public function sms_template_destroy(Request $request)
    {
        return $this->service->sms_template_destroy_service($request);
    }

    public function send_sms(Request $request)
    {
        return $this->service->send_sms_service($request);
    }

    public function sms_queue_list() {
        return $this->service->get_queue_list();
    }

    public function sms_log_list() {
        return $this->service->get_log_list();
    }

    public function sms_queue_details($id) {
        return $this->service->queue_details($id);
    }
    
    public function sms_log_details($id) {
        return $this->service->log_details($id);
    }

    public function single_sms_queue_delete(Request $request, $id) {
        return $this->service->single_queue_delete($request, $id);
    }

    public function all_sms_queue_delete(Request $request) {
        return $this->service->all_queue_delete($request);
    }
}
