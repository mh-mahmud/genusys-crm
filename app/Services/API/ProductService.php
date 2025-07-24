<?php
namespace App\Services\API;

use App\Models\Product;

class ProductService {

	public function getAllProducts() {
		return Product::all();
	}

}