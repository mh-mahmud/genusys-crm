<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ProductService;
use App\Helpers\Helper;
use App\Models\ProductFeature;
use App\Services\InvoiceCustomFormService;
use App\Models\ProductTemplate;


class ProductController extends Controller {

    protected $productService;
    protected $invoiceCustomFormService;

    public function __construct(ProductService $productService, InvoiceCustomFormService $invoiceCustomFormService)
    {
        $this->productService = $productService;
        $this->invoiceCustomFormService = $invoiceCustomFormService;
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

        } else {
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

    // ================= custom form ======================= //
    public function indexForm()
    {
        $forms = ProductTemplate::all();
        return view('products.formlist', compact('forms'));
    }
    public function createForm()
    {
        return view('invoice_custom.create');
    }

    public function storeForm(Request $request)
    {  
        $data = $request->validate([
            'invoice_name' => 'required|string|max:255',
            'field_details' => 'array',
            'field_details.*.field_name' => 'required|string',
            'field_details.*.is_sum' => 'required',
            'field_details.*.is_mandatory' => 'required',
            'total_in_word' => 'nullable|string|max:255',
            'bank_details' => 'nullable|string',
            'issued_by' => 'nullable|string',
        ], [
            //custom error messages
            'field_details.*.field_name.required' => 'Each Item Field Name is required.',
            'field_details.*.field_value.required' => 'Each Item Field Value is required.',
            'field_details.*.is_sum.required' => 'Is Sum is required.',
            'field_details.*.is_mandatory.required' => 'Is Mandatory Field Value is required.',
            'invoice_name.required' => 'The Invoice Name is required.',
            'total_in_word.max' => 'The Total in Words field should not exceed 255 characters.',
        ]);
        $this->invoiceCustomFormService->createCustomInvoice($data);

        return redirect()->route('invoice-custom-index')->with('success', 'Custom Invoice created successfully.');
    }

    
    public function showForm($id)
    {
        $invoice = InvoiceCustomForm::findOrFail($id);
        //directly access field_details as an array and show field name
        $fieldNames = collect($invoice->field_details)->pluck('field_name')->implode(', ');
        $footerFieldNames = collect($invoice->footer_details)->pluck('field_name')->implode(', ');
        return view('invoice_custom.show', compact('invoice','fieldNames','footerFieldNames'));
    }


    public function editForm($id)
    {
        $invoice = InvoiceCustomForm::findOrFail($id);
        return view('invoice_custom.edit', compact('invoice'));
    }


    public function updateForm(Request $request, $id)
    {
        $request->validate([
            'invoice_name' => 'required|string|max:255',
            'field_details' => 'array',
            'field_details.*.field_name' => 'required|string',
            'total_in_word' => 'nullable|string|max:255',
            'bank_details' => 'nullable|string',
            'issued_by' => 'nullable|string',
        ], [
            'field_details.*.field_name.required' => 'Each Item Field Name is required.',
            'invoice_name.required' => 'The Invoice Name is required.',
            'total_in_word.max' => 'The Total in Words field should not exceed 255 characters.',
        ]);
        //$this->leadsFormService->updateLeadsForm($id, $request->all());
        $this->invoiceCustomFormService->updateCustomInvoice($id, $request->all());

        return redirect()->route('invoice-custom-index')->with('success', 'Custom Invoice updated successfully.');
    }


    public function destroyForm($id)
    {
        InvoiceCustomForm::destroy($id);
        return redirect()->route('invoice-custom-index')->with('success', 'Custom Invoice Deleted Successfully!');
    }

    // searech for invoice
    public function searchForm(Request $request)
    {
        $searchTerm = trim($request->input('search'));

        if (empty($searchTerm)) {
            return redirect()->route('invoice-custom-index')->with('error', 'Search field cannot be blank.');
        }

        $invoices = $this->invoiceCustomFormService->searchCustomInvoice($request);
        return view('invoice_custom.index', compact('invoices'));
    }

}