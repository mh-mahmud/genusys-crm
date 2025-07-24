<?php

namespace App\Services;
use App\Models\Country;
use Exception;
use Illuminate\Support\Facades\Auth;

class CountryService
{
    public function countryList($request)
    {
        $sql = Country::query();
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

    public function countryStore($request)
    {
        $request->validate([
            'name'          => 'required|unique:countries|max:191'
        ]);
        $data = $request->all();

        try {
            $dataObj                        = new Country();
            $dataObj->name                  = $data['name'];
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

    public function getCountryById($id)
    {
        return Country::findOrFail($id);
    }

    public function countryDelete($id)
    {
        try {
            $data = Country::findOrFail($id);
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