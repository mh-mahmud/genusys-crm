<?php

namespace App\Services;
use App\Models\ResultCode;
use Exception;
use Illuminate\Support\Facades\Auth;

class ResultCodeService
{
    public function resultCodeList($request)
    {
        $sql = ResultCode::query();
        $data = $request->all();
        if(!empty($data["search"])) {
            $sql->where('name','like', '%' . $data["search"] . '%');

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
            'code'          => 'required',
            'title'          => 'required|unique:result_codes|max:255'
        ]);
        $data = $request->all();

        try {
            $dataObj                        = new ResultCode();
            $dataObj->title                 = $data['title'];
            $dataObj->code                  = $data['code'];
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