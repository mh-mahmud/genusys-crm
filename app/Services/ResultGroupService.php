<?php

namespace App\Services;
use App\Models\GroupCode;
use Exception;
use Illuminate\Support\Facades\Auth;

class ResultGroupService
{
    public function resultGroupList($request)
    {
        $sql = GroupCode::query();
        $data = $request->all();
        if(!empty($data["search"])) {
            $sql->where('group_code','like', '%' . $data["search"] . '%');

        }
        if (isset($data['paginate']) && $data['paginate'] == false) {
            return  $sql->orderBy('id', 'DESC')->get();

        } else {
            return  $sql->orderBy('id', 'DESC')->paginate(config('constants.ROW_PER_PAGE'));

        }
    }

    public function resultGroupStore($request)
    {
        $request->validate([
            'group_code'           => 'required|unique:group_code,group_code|max:50',
            'group_description'    => 'required|unique:group_code,group_description|max:255'
        ]);
        $data = $request->all();

        try {
            $dataObj                        = new GroupCode();
            $dataObj->group_code            = $data['group_code'];
            $dataObj->group_description     = $data['group_description'];
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

    public function resultGroupEdit($id)
    {
        return GroupCode::findOrFail($id);
    }

    public function resultGroupUpdate($request, $id)
    {
        $request->validate([
            'group_code'        => 'required|unique:group_code,group_code,' . $id,
            'group_description' => 'required|unique:group_code,group_description,' . $id . '|max:255',
        ]);

        $data = $request->all();

        try {
            $dataObj                        = GroupCode::findOrFail($id);
            $dataObj->group_code            = $data['group_code'];
            $dataObj->group_description     = $data['group_description'];
            $dataObj->status                = $data['status'];

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

}