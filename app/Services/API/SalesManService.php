<?php
namespace App\Services\API;

use App\Models\SalesMan;

class SalesManService {

	public function getAllSalesMan() {
		return SalesMan::all();
	}

	public function showSalesMan($id) {
		return SalesMan::find($id);
	}

	public function destroy($id) {
		return SalesMan::destroy($id);
	}

}