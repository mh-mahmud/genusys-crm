<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\CountryService;
use App\Helpers\Helper;

class CountryController extends Controller {

    protected $countryService;

    public function __construct(CountryService $countryService)
    {
        $this->countryService = $countryService;
        $this->middleware('auth');
    }

    public function countryList(Request $request)
    {      
        $countries = $this->countryService->countryList($request);
        return view('countries.country-list', compact('countries'));
    }

    public function countryCreate()
    {       
        return view('countries.create');
    }

    public function countryStore(Request $request)
    { 
        $result = $this->countryService->countryStore($request);
        if($result->status == 201){
            Helper::storeLog("Country added successfully", "Country", "Create Country");
            return redirect()->route('country-list')->with('success', 'Country added successfully.');

        }else{
            session()->flash('error', 'Can not Add!');
        }

    }

    public function countryShow($id)
    {
        $country = $this->countryService->getCountryById($id);
        return view('countries.country-show', compact('country'));
    }

    public function countryDelete($id)
    {
        $result = $this->countryService->countryDelete($id);
        if($result->status == 200){
            Helper::storeLog("Country deleted successfully", "Country", "Delete Country");
            return redirect()->route('country-list')->with('success', 'Country deleted successfully.');

        }else{
            session()->flash('error', 'Can not Delete !');
        }
    }

}