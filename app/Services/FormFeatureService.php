<?php

namespace App\Services;
use App\Models\FormFeature;
use Exception;
use Illuminate\Support\Facades\Auth;
use App\Helpers\Helper;
use DB;

class FormFeatureService
{
    public function formFeatureList($request)
    {
        $sql = FormFeature::query();
        $data = $request->all();
        if(!empty($data["search"])) {
            $sql->where('title','like', '%' . $data["search"] . '%');

        }
        if (isset($data['paginate']) && $data['paginate'] == false) {
            return  $sql->orderBy('id', 'DESC')->get();

        } else {
            return  $sql->orderBy('id', 'DESC')->paginate(config('constants.ROW_PER_PAGE'));

        }
    }

    public function formFeatureStore($request)
    {
        $request->validate([
                    'title' => 'required|string|max:255|unique:form_features,title',
                    'description' => 'required|string',
                    'route' => 'required|string|unique:form_features,route',
        ]);
        $data = $request->all();

        try {
            return  DB::transaction(function () use ($data) {
                $dataObj                        = new FormFeature();
                $dataObj->title                 = $data['title'];
                $dataObj->description           = $data['description'];
                $dataObj->route                 = $data['route'];
                $dataObj->created_by            = Auth::id();
                $dataObj->save();

                $logMessage = $data['title'].", new form feature added"; 
                Helper::storeLog($logMessage, "Form Feature", "Add Form Feature", NULL);

                return (object)[
                    'status'                 => 201,
                    'info'                   => $dataObj->id
                ];
            });
        } catch (Exception $e) {
            return (object)[
                'status'             => 424,
                'error'              => $e->getMessage()
            ];
        }
    }

    public function formFeatureUpdate($request, $id)
    {
        $request->validate([
                'title' => 'required|string|max:255|unique:form_features,title,' . $id,
                'description' => 'required|string',
                'route' => 'required|string|unique:form_features,route,' . $id,
        ]);
        $data = $request->all();

        try {
            return  DB::transaction(function () use ($data, $id) {
                $dataObj                        = FormFeature::findOrFail($id);;
                $dataObj->title                 = $data['title'];
                $dataObj->description           = $data['description'];
                $dataObj->route                 = $data['route'];
                $dataObj->updated_by            = Auth::id();
                $dataObj->save();

                $logMessage = $data['title'].",  form feature updated"; 

                Helper::storeLog($logMessage, "Form Feature", "Update Form Feature", NULL);

                return (object)[
                    'status'                 => 208,
                    'info'                   => $dataObj->id
                ];
            });


        } catch (Exception $e) {
            return (object)[
                'status'             => 424,
                'error'              => $e->getMessage()
            ];
        }

    }

    public function getFormFeatureById($id)
    {
        return FormFeature::findOrFail($id);
    }

    public function formFeatureDelete($id)
    {
        try {
            return  DB::transaction(function () use ($id) {
                $data = FormFeature::findOrFail($id);
                $data->delete();

                $logMessage = $data['name'].",  form feature deleted"; 

                Helper::storeLog($logMessage, "Form Feature", "Delete form feature", NULL);

                return (object)[
                    'status'                 => 200,
                ];

            });
        } catch (Exception $e) {
            return (object)[
                'status'             => 424,
                'error'              => $e->getMessage()
            ];
        }
    }

    public function getDescription($route)
    {
        $description = FormFeature::where('route', $route)
                        ->value('description');

        return response()->json([
            'description' => $description ?? 'No help available for this page.'
        ]);
    }
}