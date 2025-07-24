<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Services\API\SalesManService;
use App\Models\SalesMan;

class SalesManController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    protected $salesman_service;
    public function __construct(SalesManService $salesman_service) {
        $this->salesman_service = $salesman_service;
    }

    public function index()
    {
        return $this->salesman_service->getAllSalesMan();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'phone_number' => 'required',
            'address' => 'required'
        ]);
        return SalesMan::create($request->all());
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return $this->salesman_service->showSalesMan($id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $salesman = SalesMan::find($id);
        $salesman->update($request->all());
        return $salesman;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        return $this->salesman_service->destroy($id);
    }
}
