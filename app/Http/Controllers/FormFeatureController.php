<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\FormFeatureService;
use App\Helpers\Helper;


class FormFeatureController extends Controller {

    protected $formFeatureService;

    public function __construct(FormFeatureService $formFeatureService)
    {
        $this->formFeatureService = $formFeatureService;
        $this->middleware('auth');
    }

    public function formFeatureList(Request $request)
    {      
        $formFeatures = $this->formFeatureService->formFeatureList($request);
        return view('form-feature.list', compact('formFeatures'));
    }

    public function formFeatureCreate()
    {       
        return view('form-feature.create');
    }

    public function formFeatureStore(Request $request)
    { 
        $result = $this->formFeatureService->formFeatureStore($request);
        if($result->status == 201){
            return redirect()->route('feature-list')->with('success', 'Form Feature added successfully.');

        }else{
            session()->flash('error', 'Can not Add!');
        }

    }

    public function formFeatureShow($id)
    {
        $fromFeature = $this->formFeatureService->getFormFeatureById($id);
        return view('form-feature.show', compact('fromFeature'));
    }

    public function formFeatureEdit($id)
    {
        $fromFeature = $this->formFeatureService->getFormFeatureById($id);
        return view('form-feature.edit', compact('fromFeature'));
    }

    public function formFeatureUpdate(Request $request, $id)
    { 
        $result = $this->formFeatureService->formFeatureUpdate($request, $id);
        if($result->status == 208){
            return redirect()->route('feature-list')->with('success', 'Form Feature updated successfully.');

        }else{
            session()->flash('error', 'Can not Update!');
        }

    }


    public function formFeatureDelete($id)
    {
        $result = $this->formFeatureService->formFeatureDelete($id);
        if($result->status == 200){
            return redirect()->route('feature-list')->with('success', 'Form Feature deleted successfully.');

        }else{
            session()->flash('error', 'Can not Delete !');
        }
    }

    public function getDescription($route)
    {
        return $this->formFeatureService->getDescription($route);
    }

}