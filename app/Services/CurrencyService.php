<?php

namespace App\Services;
use App\Models\Currency;
use Exception;
use Illuminate\Support\Facades\Auth;

class CurrencyService
{
    public function currencyList($request)
    {
        $sql = Currency::query();
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

    public function currencyStore($request)
    {
        $request->validate([
            'name'          => 'required|unique:currencies|max:191'
        ]);
        $data = $request->all();

        try {
            $dataObj                        = new Currency();
            $dataObj->name                  = $data['name'];
            $dataObj->symbol                = $data['symbol'];
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

    public function getCurrencyById($id)
    {
        return Currency::findOrFail($id);
    }

    public function currencyDelete($id)
    {
        try {
            $data = Currency::findOrFail($id);
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