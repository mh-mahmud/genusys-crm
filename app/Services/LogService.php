<?php
namespace App\Services;

use App\Helpers\Helper;
use App\Models\Logs;

class LogService
{
    public function getLogList($request)
    {
        if ($request->start_date && $request->end_date) {
            $startDate  = $request->start_date;
            $endDate    = $request->end_date;
            if (!Helper::isDateValid($startDate, 'Y-m-d') || !Helper::isDateValid($endDate, 'Y-m-d')) {
                $errors = 'Please enter a valid date';
            }
        } else {
            $startDate = date('Y-m-d', strtotime("-" . config('constants.MAX_REPORT_DAYS') . " days"));
            $endDate   = date('Y-m-d');

        }

        if (!Helper::isDateRangeValid($startDate, $endDate)) {
            $errors = "Date range is not valid! You can see maximum " . config('constants.MAX_REPORT_DAYS') . ' days report.';
        }
        if (!empty($errors)) {
            return (object)[
                'status'    => 400,
                'errors'    => $errors
            ];
        }

        $query = Logs::join('users', 'users.id', '=', 'logs.user_id')
            ->leftJoin('leads', 'leads.id', '=', 'logs.lead_id')
            ->select(
                'logs.*', 
                'users.first_name', 
                'users.last_name', 
                'leads.first_name as lead_first_name', 
                'leads.last_name as lead_last_name'
            );

        if ($request->search) {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('logs.module', 'like', "%$searchTerm%")
                    ->orWhere('logs.sub_module', 'like', "%$searchTerm%")
                    ->orWhere('logs.log_message', 'like', "%$searchTerm%")
                    ->orWhereRaw("CONCAT(users.first_name, ' ', users.last_name) LIKE ?", ["%{$searchTerm}%"])
                    ->orWhereRaw("CONCAT(leads.first_name, ' ', leads.last_name) LIKE ?", ["%{$searchTerm}%"]);
            });
        }

        if ($request->start_date && $request->end_date) {
            $startDate = $request->start_date . ' 00:00:00';           
            $endDate = $request->end_date . ' 23:59:59';
            $query->whereBetween('logs.created_at', [$startDate, $endDate]);
        }

        $logs = $query->orderBy('logs.id', 'DESC')
            ->paginate(config('constants.ROW_PER_PAGE'))
            ->withQueryString();
            //dd($logs);die();

        return $logs;
        
    }
}
