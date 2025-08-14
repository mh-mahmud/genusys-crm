<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ResultCodeService;
use App\Helpers\Helper;


class ResultCodeController extends Controller {

    protected $resultCodeService;

    public function __construct(ResultCodeService $resultCodeService)
    {
        $this->resultCodeService = $resultCodeService;
        $this->middleware('auth');
    }

    public function resultCodeList(Request $request)
    {     
        $codes = $this->resultCodeService->resultCodeList($request);
        return view('result-code.list', compact('codes'));
    }

    public function resultCodeCreate()
    {   
        $data = Helper::resultCodeDropDownData();
        return view('result-code.create', $data);
    }

    public function resultCodeStore(Request $request)
    { 
        $result = $this->resultCodeService->resultCodeStore($request);
        // dd($result);
        if($result->status == 201){
            Helper::storeLog("Result code added successfully", "Result code", "Create Result code");
            return redirect()->route('result-code-list')->with('success', 'Result code added successfully.');

        }else{
            session()->flash('error', 'Can not Add!');
        }

    }

    public function resultCodeShow($id)
    {
        $country = $this->resultCodeService->getresultCodeById($id);
        return view('countries.country-show', compact('resultCode'));
    }

    public function resultCodeDelete($id)
    {
        $result = $this->resultCodeService->resultCodeDelete($id);
        if($result->status == 200){
            Helper::storeLog("Country deleted successfully", "Country", "Delete Country");
            return redirect()->route('result-code-list')->with('success', 'Country deleted successfully.');

        }else{
            session()->flash('error', 'Can not Delete !');
        }
    }

}