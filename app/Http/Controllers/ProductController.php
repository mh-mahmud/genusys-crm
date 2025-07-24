<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ProductService;
use App\Helpers\Helper;
use App\Models\ProductFeature;


class ProductController extends Controller {

    protected $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
        $this->middleware('auth');
    }

    public function productList(Request $request)
    {      
        $products = $this->productService->productList($request);
        return view('products.product-list', compact('products'));
    }

    public function productCreate()
    {       
        return view('products.create');
    }

    public function productStore(Request $request)
    { 
        $result = $this->productService->productStore($request);
        if($result->status == 201){
            Helper::storeLog("Product added successfully", "Product", "Create Product");
            return redirect()->route('product-list')->with('success', 'Product added successfully.');

        }else{
            session()->flash('error', 'Can not Add!');
        }

    }

    public function productShow($id)
    {
        $product = $this->productService->getProductById($id);
        $productFeatures = ProductFeature::where('product_id', $product->id)->get();
        return view('products.product-show', compact('product','productFeatures'));
    }

    public function productEdit($id)
    {
        $product = $this->productService->getProductById($id);
        return view('products.edit', compact('product'));
    }

    public function productUpdate(Request $request, $id)
    { 
        $result = $this->productService->productUpdate($request, $id);
        if($result->status == 208){
            Helper::storeLog("Product updated successfully", "Product", "Edit Product");
            return redirect()->route('product-list')->with('success', 'Product updated successfully.');

        }else{
            session()->flash('error', 'Can not Update!');
        }

    }


    public function productDelete($id)
    {
        $result = $this->productService->productDelete($id);
        if($result->status == 200){
            Helper::storeLog("Product deleted successfully", "Product", "Delete Product");
            return redirect()->route('product-list')->with('success', 'Product deleted successfully.');

        }else{
            session()->flash('error', 'Can not Delete !');
        }
    }


    public function productFeatureStore(Request $request)
    {
        $request->validate([
            'p_feature_name' => 'required|string|max:191',
            'unit_price' => 'required|numeric|min:0',
            'product_id' => 'required|exists:products,id',
        ], [
            'p_feature_name.required' => 'The Product Feature Name field is required.',
            'unit_price.required' => 'The Unit Price field is required.',
            'unit_price.numeric' => 'The Unit Price must be a valid number.',
            'unit_price.min' => 'The Unit Price must be at least 0.',
            'product_id.required' => 'The Product ID is required.',
            'product_id.exists' => 'The selected Product ID is invalid.',
        ]);

        $this->productService->createProductFeature($request->all());
        Helper::storeLog("Product Feature added successfully", "Product", "Create Product Feature");

        return redirect()->route('product-show', $request->product_id)->with('success', 'Product Feature added successfully.');
    }

    public function productFeatureUpdate(Request $request, $id)
    {
        $request->validate([
            'p_feature_name' => 'required|string|max:191',
            'unit_price' => 'required|numeric|min:0',
        ], [
            'p_feature_name.required' => 'The Product Feature Name field is required.',
            'unit_price.required' => 'The Unit Price field is required.',
            'unit_price.numeric' => 'The Unit Price must be a valid number.',
            'unit_price.min' => 'The Unit Price must be at least 0.',
        ]);

        $this->productService->updateProductFeature($request->all(), $id);
        Helper::storeLog("Product Feature updated successfully", "Product", "Update Product Feature");
        return redirect()->route('product-show', $request->product_id)->with('success', 'Product Feature updated successfully.');
    }

    public function product_features_show(Request $request)
    {
        $values = $request->product_feature_values; // Retrieve values from AJAX request

        if (!$values) {
            return response()->json(['status' => 'error', 'message' => 'No values received!'], 400);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Features retrieved successfully!',
            'data' => $values
        ]);
    }


    public function destroy($id)
    {
        $productFeature = ProductFeature::findOrFail($id);
        $productId = $productFeature->product_id;
        $this->productService->deleteProductFeature($id);
        Helper::storeLog("Product Feature deleted successfully", "Product", "Delete Product Feature");
        return redirect()->route('product-show', $productId)->with('success', 'Product Feature deleted successfully.');
    }

}