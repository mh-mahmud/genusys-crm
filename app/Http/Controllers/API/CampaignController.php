<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Services\API\CampaignService;
use App\Models\Campaign;

class CampaignController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    protected $campaign_service;
    public function __construct(CampaignService $campaign_service) {
        $this->campaign_service = $campaign_service;
    }

    public function index()
    {
        return $this->campaign_service->getAllCampaign();
    }

    /**
     * Store a newly created resource in storage.
     */

    public function store(Request $request)
    {
        $request->validate([
            'campaign_title' => 'required',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        // Create Campaign
        $campaign = new Campaign();
        $campaign->campaign_title = $request->input('campaign_title');
        $campaign->start_date = $request->input('start_date');
        $campaign->end_date = $request->input('end_date');
        $campaign->description = $request->input('description');
        $campaign->campaign_type = $request->input('campaign_type');
        $campaign->campaign_limit = $request->input('campaign_limit');
        $campaign->campaign_service = $request->input('campaign_service');
        $campaign->status = $request->input('status');
        $campaign->promotion_id = $request->input('promotion_id');
        $campaign->save();

        return $campaign;
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return $this->campaign_service->showCampaign($id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {   
        $request->validate([
            'campaign_title' => 'required',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);
        $campaign = Campaign::find($id);
        $campaign->update($request->all());
        return $campaign;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        return $this->campaign_service->destroy($id);
    }
}
