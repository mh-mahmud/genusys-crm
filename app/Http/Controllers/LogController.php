<?php
namespace App\Http\Controllers;
use App\Services\LogService;

use Illuminate\Http\Request;


class LogController extends Controller {
    protected $logService;

    public function __construct(LogService $logService)
    {
        $this->logService = $logService;
        $this->middleware('auth');
    }

    public function getLogList(Request $request)
    {      
        $logs = $this->logService->getLogList($request);
        if (is_object($logs) && isset($logs->status) && $logs->status == 400) {
            $errors = $logs->errors;
            session()->flash('error', $errors);
            return view('log.logs');
        }
        return view('log.logs', compact('logs'));
    }

}