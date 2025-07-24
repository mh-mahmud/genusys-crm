<?php


namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Services\API\ProductService;
use App\Models\Product;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    protected $product_service;
    public function __construct(ProductService $product_service) {
        $this->product_service = $product_service;
    }
    public function index()
    {
        return $this->product_service->getAllProducts();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'product_type' => 'required',
            'status' => 'required'
        ]);
        return Product::create($request->all());
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return Product::find($id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $product = Product::find($id);
        $product->update($request->all());
        return $product;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        return Product::destroy($id);
    }

    public function search($name) {
        return Product::where('name', 'like', '%' . $name . '%')->get();
    }
}
