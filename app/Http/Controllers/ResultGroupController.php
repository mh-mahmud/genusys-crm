<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ResultGroupService;
use App\Helpers\Helper;

class ResultGroupController extends Controller {

    protected $resultGroupService;

    public function __construct(ResultGroupService $resultGroupService)
    {
        $this->resultGroupService = $resultGroupService;
        $this->middleware('auth');
    }

    public function resultGroupList(Request $request)
    {      
        $result_groups = $this->resultGroupService->resultGroupList($request);
        return view('result-group.list', compact('result_groups'));
    }

    public function resultGroupCreate()
    {       
        return view('result-group.create');
    }

    public function resultGroupStore(Request $request)
    { 
        $result = $this->resultGroupService->ResultGroupStore($request);
        if($result->status == 201){
            Helper::storeLog("ResultGroup added successfully", "ResultGroup", "Create ResultGroup");
            return redirect()->route('result-group-list')->with('success', 'ResultGroup added successfully.');

        }else{
            session()->flash('error', 'Can not Add!');
        }

    }

    public function resultGroupEdit($id)
    {
        $result_group = $this->resultGroupService->resultGroupEdit($id);
        return view('result-group.edit', compact('result_group'));
    }

    public function resultGroupUpdate(Request $request, $id)
    { 
        $result = $this->resultGroupService->resultGroupUpdate($request, $id);
        if($result->status == 200){
            Helper::storeLog("Result group updated successfully", "Result group", "Update Result group");
            return redirect()->route('result-group-list')->with('success', 'Result group updated successfully.');

        }else{
            session()->flash('error', 'Can not Update!');
        }

    }
}