<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ResultActionService;
use App\Helpers\Helper;

class ResultActionController extends Controller {

    protected $resultActionService;

    public function __construct(ResultActionService $resultActionService)
    {
        $this->resultActionService = $resultActionService;
        $this->middleware('auth');
    }

    public function resultActionList(Request $request)
    {     
        $actions = $this->resultActionService->resultActionList($request);
        return view('result-action.list', compact('actions'));
    }

    public function resultActionCreate()
    {   
        $data = Helper::resultActionDropDownData();
        return view('result-action.create', $data);
    }

    public function resultActionStore(Request $request)
    { 
        $result = $this->resultActionService->resultActionStore($request);
        if($result->status == 201){
            Helper::storeLog("Result action added successfully", "Result Action", "Create Result Action");
            return redirect()->route('result-action-list')->with('success', 'Result action added successfully.');
        } else {
            session()->flash('error', 'Can not Add!');
        }
    }

    public function resultActionShow($id)
    {
        $action = $this->resultActionService->getResultActionById($id);
        return view('result-action.show', compact('action'));
    }

    public function resultActionEdit($id)
    {
        $data = Helper::resultActionDropDownData();
        $data["result_action"] = $this->resultActionService->getResultActionById($id);
        return view('result-action.edit', $data);
    }

    public function resultActionUpdate(Request $request, $id)
    { 
        $result = $this->resultActionService->resultActionUpdate($request, $id);
        if($result->status == 200){
            Helper::storeLog("Result action updated successfully", "Result Action", "Update Result Action");
            return redirect()->route('result-action-list')->with('success', 'Result action updated successfully.');
        } else {
            session()->flash('error', 'Can not Update!');
        }
    }

    public function resultActionDelete($id)
    {
        $result = $this->resultActionService->resultActionDelete($id);
        if($result->status == 200){
            Helper::storeLog("Result action deleted successfully", "Result Action", "Delete Result Action");
            return redirect()->route('result-action-list')->with('success', 'Result action deleted successfully.');
        } else {
            session()->flash('error', 'Can not Delete !');
        }
    }
}
