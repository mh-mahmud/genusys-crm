<?php

namespace App\Services;
use App\Models\Product;
use Exception;
use Illuminate\Support\Facades\Auth;
use App\Helpers\Helper;
use App\Models\ProductFeature;
use App\Models\ProductTemplate;
use DB;

class ProductService
{
    public function productList($request)
    {
        $sql = Product::query();
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

    public function productStore($request)
    {
        $request->validate([
            'name' => 'required|unique:products|max:191',
            'product_code' => 'required|max:20|unique:products',
            'product_type' => 'required',
            'product_cost' => [
                'nullable',
                'numeric',
                'regex:/^\d{1,11}(\.\d{1,2})?$/'
            ],
            'product_value' => [
                'nullable',
                'numeric',
                'regex:/^\d{1,11}(\.\d{1,2})?$/'
            ],
        ], [
            'product_cost.regex' => 'The product cost must have at most 11 digits before the decimal point and up to 2 digits after the decimal point.',
            'product_value.regex' => 'The product value must have at most 11 digits before the decimal point and up to 2 digits after the decimal point.',
        ]);
        $data = $request->all();

        //dd($data);

        $fileNameToStore = '';
        if ($request->hasFile('img_path')) {
            $fileNameWithExt = $request->file('img_path')->getClientOriginalName();
            $fileName = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
            $extension = $request->file('img_path')->getClientOriginalExtension();
            $fileNameToStore = $fileName.'_'.time().'.'.$extension;
            $request->file('img_path')->move(getcwd().'/uploads/products', $fileNameToStore);
            
        } 

        try {
            return  DB::transaction(function () use ($data, $fileNameToStore) {
                $dataObj                        = new Product();
                $dataObj->name                  = $data['name'];
                $dataObj->product_type          = $data['product_type'];
                $dataObj->product_cost          = $data['product_cost'];
                $dataObj->product_value         = $data['product_value'];
                $dataObj->product_code          = $data['product_code'];
                $dataObj->description           = $data['description'];
                $dataObj->status                = $data['status'];
                $dataObj->img_path              = $fileNameToStore;
                $dataObj->created_by            = Auth::id();
                $dataObj->save();

                $logMessage = $data['name'].", new product added"; 
                Helper::storeLog($logMessage, "Products", "Add Product", NULL);

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

    public function productUpdate($request, $id)
    {
        $request->validate([
            'name'         => 'required|max:191|unique:products,name,'.$id,
            'product_code'  => 'required|max:20',
            'product_type'  => 'required',
            'product_cost' => [
                'nullable',
                'numeric',
                'regex:/^\d{1,11}(\.\d{1,2})?$/'
            ],
            'product_value' => [
                'nullable',
                'numeric',
                'regex:/^\d{1,11}(\.\d{1,2})?$/'
            ],
        ], [
            'product_cost.regex' => 'The product cost must have at most 11 digits before the decimal point and up to 2 digits after the decimal point.',
            'product_value.regex' => 'The product value must have at most 11 digits before the decimal point and up to 2 digits after the decimal point.',
        ]);
        $data = $request->all();
        $fileNameToStore = '';
        if ($request->hasFile('img_path')) {
            $fileNameWithExt = $request->file('img_path')->getClientOriginalName();
            $fileName = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
            $extension = $request->file('img_path')->getClientOriginalExtension();
            $fileNameToStore = $fileName.'_'.time().'.'.$extension;
            $request->file('img_path')->move(getcwd().'/uploads/products', $fileNameToStore);
            
        } 

        try {
            return  DB::transaction(function () use ($data, $fileNameToStore, $request, $id) {
                $dataObj                        = Product::findOrFail($id);;
                $dataObj->name                  = $data['name'];
                $dataObj->product_type          = $data['product_type'];
                $dataObj->product_cost          = $data['product_cost'];
                $dataObj->product_value         = $data['product_value'];
                $dataObj->product_code          = $data['product_code'];
                $dataObj->description           = $data['description'];
                $dataObj->status                = $data['status'];
                $dataObj->img_path              = $request->hasFile('img_path') ? $fileNameToStore : $dataObj->img_path;
                $dataObj->updated_by            = Auth::id();
                $dataObj->save();

                $logMessage = $data['name'].",  product updated"; 

                Helper::storeLog($logMessage, "Products", "Update Product", NULL);

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

    public function getProductById($id)
    {
        return Product::findOrFail($id);
    }

    public function productDelete($id)
    {
        try {
            return  DB::transaction(function () use ($id) {
                $data = Product::findOrFail($id);
                $data->delete();

                $logMessage = $data['name'].",  product deleted"; 

                Helper::storeLog($logMessage, "Products", "Delete Product", NULL);

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


    public function createProductFeature($data)
    {
        return ProductFeature::create($data);
    }

    public function updateProductFeature($data, $id)
    {
        $productFeature = ProductFeature::findOrFail($id);
        $productFeature->p_feature_name = $data['p_feature_name'];
        $productFeature->unit_price = $data['unit_price'];
        $productFeature->save();
        return $productFeature;
    }


    public function deleteProductFeature($id)
    {
        $productFeature = ProductFeature::findOrFail($id);
        $productFeature->delete();
    }

    public function createTable($templateName, $templateId, $fields)
    {

        // get template id
        if($templateId===null) {
            // table already exists show this message
            $data = ProductTemplate::where('template_name', $templateName)->first();
            if ($data) {
                return 'Table already exists.';
            }

            $temp = ProductTemplate::max('template_id');
            if(empty($temp)) {
                $templateId = 1001;
            }
            else {
                $templateId = $temp + 1;
            }
        }
        else {
            // remove previous data
            DB::select("DELETE FROM product_templates WHERE template_id='{$templateId}'");
        }


        //insert data in table
        $data = [];
        foreach ($fields as $field) {
            $data[] = [
                'template_id' => $templateId,
                'field_name' => $field['name'],
                'field_value' => $field['type'],
                'template_name' => $templateName,
                'character_length' => $field['character_length'] ?? null,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        
        DB::table('product_templates')->insert($data);

        return 'Data inserted successfully.';
    }

    public function getDetailsByTableName($template_id)
    {
        return ProductTemplate::where('template_id', $template_id)->get();
    }

}