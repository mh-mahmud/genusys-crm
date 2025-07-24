<?php

namespace App\Services;
use App\Models\User;
use App\Models\Task;
use Exception;
use Illuminate\Support\Facades\Auth;
use App\Helpers\Helper;
use DB;
class TaskService
{
    public function getTaskList()
    {
        $sql = Task::query();
        if(Auth::user()->user_type != 'admin') {
            $sql->where('assigned_to', Auth::id());
        } else {
            $sql->leftJoin('users', 'users.id', '=', 'tasks.assigned_to')
                ->select('tasks.*', 'users.first_name', 'users.last_name');
        }
        return $sql->orderBy('id', 'DESC')->paginate(config('constants.ROW_PER_PAGE'));
    }


    public function getUsers()
    {
        return User::where(function ($query) {
                    $query->where('role_id', '!=', config('constants.ADMIN_ROLE_ID'))
                        ->orWhereNull('role_id');
                })
                ->where('status', 1)
                ->get();  
    }

    public function addTaskPro($request)
    {
        if(Auth::user()->user_type == 'admin') {
            $request->validate([
                'task_name' => 'required',
                'due_date' => 'required',
                'assigned_to' => 'required',
            ]);
        } else {
            $request->validate([
                'task_name' => 'required',
                'due_date' => 'required',
            ]);
        }
       
        $data = $request->all();
        try {
            return  DB::transaction(function () use ($data) {
                $dataObj                        = new Task();
                $dataObj->task_name             = $data['task_name'];
                $dataObj->assigned_to           = Auth::user()->user_type == 'admin' ? $data['assigned_to'] : Auth::id();
                $dataObj->description           = $data['description'];
                $dataObj->due_date              = $data['due_date'];
                // $dataObj->status                = config('constants.TASK_TO_DO');
                $dataObj->status                = 0;
                $dataObj->created_by            = Auth::id();
                $dataObj->save();   
                
                Helper::storeLog("New task added, ".$data['task_name'], "Tasks", "Add Task", NULL);
                
                return (object)[
                    'status'                 => 201,
                    'info'                   => $dataObj->id
                ];
            });
        } catch (Exception $e) {
            return (object)[
                'status'             => 424,
                'error'              => $e->getMessage()
            ];
        }
    }

    public function changeStatus($request, $id)
    {
        $data = $request->all();

        try {
            return  DB::transaction(function () use ($data, $id) {
                $dataObj                        = Task::findOrFail($id);
                $dataObj->status                = $data['status'];
                $dataObj->save();

                Helper::storeLog("Status Change of task, ".$dataObj['task_name'], "Tasks", "Task Status Change", NULL);
               
                return (object)[
                    'status'                 => 208,
                    'info'                   => $dataObj->id
                ];
            });

        } catch (Exception $e) {
            return (object)[
                'status'             => 424,
                'error'              => $e->getMessage()
            ];
        }
    }

    public function taskDelete($id)
    {
        try {
            return  DB::transaction(function () use ($id) {
                $task = Task::findOrFail($id);
                $task->delete();

                Helper::storeLog("Delete task, ".$task['task_name'], "Tasks", "Task Delete", NULL);
                
                return (object)[
                    'status'                 => 200,
                ];
            });
        } catch (Exception $e) {
            return (object)[
                'status'             => 424,
                'error'              => $e->getMessage()
            ];
        }

    }
}