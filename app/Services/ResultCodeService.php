<?php

namespace App\Services;
use App\Models\ResultCode;
use Exception;
use Illuminate\Support\Facades\Auth;
class ResultCodeService
{
    public function resultCodeList($request)
    {
        $sql = ResultCode::with([
                    'groupCode:id,group_code,group_description',      
                    'resultAction:id,rule_code,rule_description',  
                    'leadStatus:id,status_name'   
                ]);
        $data = $request->all();
        if(!empty($data["search"])) {
            $sql->where('title','like', '%' . $data["search"] . '%')
              ->orWhere('code', 'like', '%' . $data["search"] . '%');

        }
        if (isset($data['paginate']) && $data['paginate'] == false) {
            return  $sql->orderBy('id', 'DESC')->get();

        } else {
            return  $sql->orderBy('id', 'DESC')->paginate(config('constants.ROW_PER_PAGE'));

        }
    }

    public function resultCodeStore($request)
    {
        $request->validate([
            'code'           => 'required|unique:result_codes,code',
            'title'          => 'required|unique:result_codes,title|max:255'
        ]);
        $data = $request->all();

        try {
            $dataObj                        = new ResultCode();
            $dataObj->title                 = $data['title'];
            $dataObj->code                  = $data['code'];
            $dataObj->result_group_id       = $data['result_group_id'];
            $dataObj->result_action_id      = $data['result_action_id'];
            $dataObj->lead_status_id        = $data['lead_status_id'];
            $dataObj->comment_required      = $data['comment_required'];
            $dataObj->selectable            = $data['selectable'];
            $dataObj->created_by            = Auth::id();
            $dataObj->status                = $data['status'];

            $dataObj->save();

        } catch (Exception $e) {
            return (object)[
                'status'             => 424,
                'error'              => $e->getMessage()
            ];
        }

        return (object)[
            'status'                 => 201,
            'info'                   => $dataObj->id
        ];

    }

    public function resultCodeUpdate($request, $id)
    {
        $request->validate([
            'code'  => 'required|unique:result_codes,code,' . $id,
            'title' => 'required|unique:result_codes,title,' . $id . '|max:255',
        ]);

        $data = $request->all();

        try {
            $dataObj = ResultCode::findOrFail($id);

            $dataObj->title            = $data['title'];
            $dataObj->code             = $data['code'];
            $dataObj->result_group_id  = $data['result_group_id'];
            $dataObj->result_action_id = $data['result_action_id'];
            $dataObj->lead_status_id   = $data['lead_status_id'];
            $dataObj->comment_required = $data['comment_required'];
            $dataObj->selectable       = $data['selectable'];
            $dataObj->status           = $data['status'];
            $dataObj->updated_by       = Auth::id(); 

            $dataObj->save();

        } catch (Exception $e) {
            return (object)[
                'status' => 424,
                'error'  => $e->getMessage()
            ];
        }

        return (object)[
            'status' => 200,
            'info'   => $dataObj->id
        ];
    }

    public function getResultCodeById($id)
    {
        return ResultCode::findOrFail($id);
    }

    public function resultCodeDelete($id)
    {
        try {
            $data = ResultCode::findOrFail($id);
            $data->delete();
        } catch (Exception $e) {
            return (object)[
                'status'             => 424,
                'error'              => $e->getMessage()
            ];
        }

        return (object)[
            'status'                 => 200,
        ];
    }

    
}