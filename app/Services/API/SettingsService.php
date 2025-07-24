<?php
namespace App\Services\API;

use App\Models\Product;
use App\Models\City;
use App\Models\State;
use App\Models\Branch;
use App\Models\Country;

class SettingsService {

	public function getAllProducts() {
		return Product::all();
	}

}