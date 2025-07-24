<?php

namespace App\Services;

use App\Models\ProductSpecification;
use App\Models\ProductSpecificationDetail;
use App\Models\ProductFeature;
use Illuminate\Support\Facades\Storage;
use App\Models\Product;

class ProductSpecificationService
{

    public function getAllProductSpecifications_backup()
{
    return ProductSpecification::join('customers', 'product_specification.customer_id', '=', 'customers.id')
        ->join('leads', 'customers.lead_id', '=', 'leads.id')
        ->select('product_specification.*','customers.customer_group','leads.first_name','leads.last_name')
        ->orderBy('product_specification.created_at', 'desc') 
        ->paginate(config('constants.ROW_PER_PAGE'));
}

    public function getAllProductSpecifications()
    {
        $productSpecifications = ProductSpecification::join('customers', 'product_specification.customer_id', '=', 'customers.id')
        ->join('leads', 'customers.lead_id', '=', 'leads.id')
        ->select(
            'product_specification.*',
            'customers.customer_group',
            'leads.first_name',
            'leads.last_name'
        )
            ->orderBy('product_specification.created_at', 'desc')
            ->paginate(config('constants.ROW_PER_PAGE'));

        foreach ($productSpecifications as $specification) {
            $productIds = explode(',', $specification->product_id); // Convert string to array
            $productNames = Product::whereIn('id', $productIds)->pluck('name')->toArray();
            $specification->product_names = implode(', ', $productNames);
        }

        return $productSpecifications;
    }

    public function getProductSpecificationById_backup($id)
    {
        return ProductSpecification::join('customers', 'product_specification.customer_id', '=', 'customers.id')
        ->join('leads', 'customers.lead_id', '=', 'leads.id')
        ->select('product_specification.*', 'customers.customer_group', 'leads.first_name', 'leads.last_name')
        ->where('product_specification.id', $id)
        ->firstOrFail();
    }


    public function getProductSpecificationById($id)
    {
        $specification = ProductSpecification::join('customers', 'product_specification.customer_id', '=', 'customers.id')
        ->join('leads', 'customers.lead_id', '=', 'leads.id')
        ->select(
            'product_specification.*',
            'customers.customer_group',
            'leads.first_name',
            'leads.last_name'
        )
        ->where('product_specification.id', $id)
        ->firstOrFail();
        $productIds = $specification->product_id ? explode(',', $specification->product_id) : [];//comma-separated string to array,
        $specification->product_ids = $productIds; //product ids to the object
        $productNames = Product::whereIn('id', $productIds)->pluck('name')->toArray();
        $specification->product_names = implode(', ', $productNames);
        return $specification;
    }


    public function createProductSpecification($data, $product_data)
    {
        //dd($data);die();
        $specificationData = $data->except([
            'work_order_file',
            'purchase_order_file',
            'amc_agreement_documents',
            'invoice_mushak_file',
            'tax_exemption_certificate'
        ]);

        //array to comma-separated
        if ($data->has('product_id') && is_array($data->input('product_id'))) {
            $specificationData['product_id'] = implode(',', $data->input('product_id'));
        }
       //handle file uploads each specified field
        $fileFields = [
            'work_order_file',
            'purchase_order_file',
            'amc_agreement_documents',
            'invoice_mushak_file',
            'tax_exemption_certificate'
        ];

        foreach ($fileFields as $field) {
            if ($data->hasFile($field)) {
                $file = $data->file($field);
                $fileName = time() . '_' . $file->getClientOriginalName();
                //$file->move(public_path('uploads/product_specification'), $fileName);
                $file->move(getcwd().'/uploads/product_specification', $fileName);
                $specificationData[$field] = $fileName;
            }
        }

        $res = ProductSpecification::create($specificationData);

        foreach($product_data as $key=>$val) {
            $product_id = $key;
            for($i=0; $i<count($val['feature_name']); $i++) {
                $spd = new ProductSpecificationDetail();
                $spd->work_order_id = $res->id;
                $spd->product_id = $product_id;
                $spd->product_feature_id = $this->get_product_feature_id($val['feature_name'][$i]);
                $spd->product_feature_name = $val['feature_name'][$i];
                $spd->unit_price = $val['unit_price'][$i];
                $spd->quantity = $val['quantity'][$i];
                $spd->save();
            }
        }
        return $res;

    }

    private function get_product_feature_id($name) {
        $res = ProductFeature::where('p_feature_name', $name)->first();
        if(!empty($res)) {
            return $res->id;
        }
        return null;
    }

    public function features_data($id) {
        $data = ProductSpecificationDetail::with('product')->where('work_order_id', $id)->get();
        $data_set = [];
        if(!empty($data)) {
            for($i=0; $i<count($data); $i++) {
                $data_set[$data[$i]->product_id][] = $data[$i];
            }
        }
        return $data_set;
    }


    public function updateProductSpecification($data, $id,$product_data)
    {
        $productSpecification = ProductSpecification::findOrFail($id);

        //exclude file fields for initial update
        $specificationData = $data->except([
            'work_order_file',
            'purchase_order_file',
            'amc_agreement_documents',
            'invoice_mushak_file',
            'tax_exemption_certificate'
        ]);

        //array to comma-separated
        if ($data->has('product_id') && is_array($data->input('product_id'))) {
            $specificationData['product_id'] = implode(',', $data->input('product_id'));
        }

        //handle file uploads
        $fileFields = [
            'work_order_file',
            'purchase_order_file',
            'amc_agreement_documents',
            'invoice_mushak_file',
            'tax_exemption_certificate'
        ];

        foreach ($fileFields as $field) {
            if ($data->hasFile($field)) {
                //delete old file
                if ($productSpecification->$field && file_exists(getcwd() . '/uploads/product_specification/' . $productSpecification->$field)) {
                    unlink(getcwd() . '/uploads/product_specification/' . $productSpecification->$field);
                }

                //upload new file
                $file = $data->file($field);
                $fileName = time() . '_' . $file->getClientOriginalName();
                $file->move(getcwd() . '/uploads/product_specification', $fileName);
                $specificationData[$field] = $fileName;
            }
        }

         $productSpecification->update($specificationData);
         
        // old specification details
        ProductSpecificationDetail::where('work_order_id', $id)->delete();

        // recreate specification details
        foreach ($product_data as $product_id => $val) {
            for ($i = 0; $i < count($val['feature_name']); $i++) {
                ProductSpecificationDetail::create([
                    'work_order_id' => $id,
                    'product_id' => $product_id,
                    'product_feature_id' => $this->get_product_feature_id($val['feature_name'][$i]),
                    'product_feature_name' => $val['feature_name'][$i],
                    'unit_price' => $val['unit_price'][$i],
                    'quantity' => $val['quantity'][$i],
                ]);
            }
        }

        return $productSpecification;
    }
    



    public function searchroductSpecification_backup($request)
    {
        $searchTerm = trim($request->input('search'));
        $query = ProductSpecification::query();

        $query->where(function($q) use ($searchTerm) {
            $q->where('work_order_number', 'LIKE', '%' . $searchTerm . '%')
              ->orWhere('work_order_value', 'LIKE', '%' . $searchTerm . '%')
              ->orWhere('amc_start_date', 'LIKE', '%' . $searchTerm . '%');
        });

        return $query->paginate(config('constants.ROW_PER_PAGE'));
    }

    public function searchProductSpecification($request)
    {
        $searchTerm = trim($request->input('search'));
        $productSpecifications = ProductSpecification::join('customers', 'product_specification.customer_id', '=', 'customers.id')
            ->join('leads', 'customers.lead_id', '=', 'leads.id')
            ->select(
                'product_specification.*',
                'customers.customer_group',
                'leads.first_name',
                'leads.last_name'
            )
            ->where(function($q) use ($searchTerm) {
                $q->where('work_order_number', 'LIKE', '%' . $searchTerm . '%')
                  ->orWhere('work_order_value', 'LIKE', '%' . $searchTerm . '%')
                  ->orWhere('amc_start_date', 'LIKE', '%' . $searchTerm . '%');
            })
            ->orderBy('product_specification.created_at', 'desc')
            ->paginate(config('constants.ROW_PER_PAGE')); 
    
        foreach ($productSpecifications as $specification) {
            $productIds = explode(',', $specification->product_id); 
            $productNames = Product::whereIn('id', $productIds)->pluck('name')->toArray();
            $specification->product_names = implode(', ', $productNames); // Convert array to string
        }
    
        return $productSpecifications;
    }
    

    public function deleteProductSpecification($id)
    {
        
        $productSpecification = ProductSpecification::findOrFail($id);
        $fileFields = [
            'work_order_file',
            'purchase_order_file',
            'amc_agreement_documents',
            'invoice_mushak_file',
            'tax_exemption_certificate'
        ];
        foreach ($fileFields as $field) {
            if ($productSpecification->$field) {
                // construct the file path
                $existingFilePath = getcwd() . '/uploads/product_specification/' . $productSpecification->$field;
              if (file_exists($existingFilePath)) {
                    unlink($existingFilePath);
                }
            }
        }
       $productSpecification->delete();
    }
    
    
}
