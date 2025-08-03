<?php

namespace App\Services;

use App\Models\Notification;
use App\Models\Invoice;
use Auth;

class NotificationService {

    public function getAllNotifications() {

        if (Auth::user()->user_type == 'admin') {
            return Notification::leftJoin('leads', 'notifications.lead_id', '=', 'leads.id')
                ->leftJoin('users', 'notifications.notify_by', '=', 'users.id')
                ->select(
                    'notifications.*',
                    'leads.first_name as lead_first_name',
                    'leads.last_name as lead_last_name',
                    'leads.email as lead_email',
                    'users.first_name as user_first_name',
                    'users.last_name as user_last_name',
                    'users.email as user_email'
                )
                ->orderBy('notifications.created_at', 'desc')
                ->paginate(config('constants.ROW_PER_PAGE'));
        }
        else {
            return Notification::leftJoin('leads', 'notifications.lead_id', '=', 'leads.id')
                ->leftJoin('users', 'notifications.notify_by', '=', 'users.id')
                ->select(
                    'notifications.*',
                    'leads.first_name as lead_first_name',
                    'leads.last_name as lead_last_name',
                    'leads.email as lead_email',
                    'users.first_name as user_first_name',
                    'users.last_name as user_last_name',
                    'users.email as user_email'
                )
                ->where('notify_by', Auth::user()->id)
                ->orderBy('notifications.created_at', 'desc')
                ->paginate(config('constants.ROW_PER_PAGE'));
        }
    }



    public function createNotification($data)
    {
        return Notification::create($data);
    }

    public function getNotificationById($id)
    {
        $update = Notification::findOrFail($id);
        $update->notify_seen = 1;
        $update->save();
        return $update;
    }

    public function updateNotification($id, $data)
    {
        $notification = Notification::findOrFail($id);
        $notification->update($data);

        return $notification;
    }

    public function deleteNotification($id)
    {
        $notification = Notification::findOrFail($id);
        $notification->delete();
    }

    public function searchNotifications($request) {
    $searchTerm = trim($request->input('search'));

    return Notification::leftJoin('leads', 'notifications.lead_id', '=', 'leads.id')
        ->leftJoin('users', 'notifications.notify_by', '=', 'users.id')
        ->where(function ($query) use ($searchTerm) {
            $query->where('notifications.notify_msg', 'LIKE', "%{$searchTerm}%")
                ->orWhere('notifications.notify_datetime', 'LIKE', "%{$searchTerm}%")
                ->orWhere('leads.first_name', 'LIKE', "%{$searchTerm}%")
                ->orWhere('leads.last_name', 'LIKE', "%{$searchTerm}%")
                ->orWhere('leads.email', 'LIKE', "%{$searchTerm}%")
                ->orWhere('users.first_name', 'LIKE', "%{$searchTerm}%")
                ->orWhere('users.last_name', 'LIKE', "%{$searchTerm}%")
                ->orWhere('users.email', 'LIKE', "%{$searchTerm}%");
        })
        ->select(
            'notifications.*',
            'leads.first_name as lead_first_name',
            'leads.last_name as lead_last_name',
            'leads.email as lead_email',
            'users.first_name as user_first_name',
            'users.last_name as user_last_name',
            'users.email as user_email'
        )
        ->orderBy('notifications.created_at', 'desc')
        ->paginate(config('constants.ROW_PER_PAGE'));
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



}
