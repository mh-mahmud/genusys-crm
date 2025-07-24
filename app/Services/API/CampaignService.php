<?php
namespace App\Services\API;

use App\Models\Campaign;

class CampaignService {

	public function getAllCampaign() {
		return Campaign::all();
	}

	public function showCampaign($id) {
		return Campaign::find($id);
	}

	public function destroy($id) {
		return Campaign::destroy($id);
	}

}