<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Services\API\PromotionService;
use App\Models\Promotion;

class PromotionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    protected $promotion_service;
    public function __construct(PromotionService $promotion_service) {
        $this->promotion_service = $promotion_service;
    }

    public function index()
    {
        return $this->promotion_service->getAllPromotion();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store_backup(Request $request)
    {
        $request->validate([
            'promotion_title' => 'required'
        ]);
        return Promotion::create($request->all());
    }


    public function store(Request $request)
    {
        $request->validate([
            'promotion_title' => 'required',
            'file_location' => 'nullable|file|mimes:pdf,jpg,jpeg,png,doc,docx|max:2048',
        ]);

        // Handle File Upload
        if ($request->hasFile('file_location')) {
            $file = $request->file('file_location');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('uploads', $fileName);
        } else {
            $filePath = null;
        }

        // Create Promotion
        $promotion = new Promotion();
        //$promotion->promotion_title = $request->promotion_title;
        $promotion->promotion_title = $request->input('promotion_title');
        $promotion->description = $request->input('description');
        $promotion->file_location = $filePath;
        $promotion->start_date = $request->input('start_date');
        $promotion->end_date = $request->input('end_date');
        $promotion->promo_type = $request->input('promo_type');
        //$promotion->status = $request->input('status', '1');
        $promotion->status = $request->input('status') ?? 1; 
        $promotion->save();

        return $promotion;
        //return redirect()->route('promotion.index')->with('success', 'Promotion created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return $this->promotion_service->showPromotion($id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'promotion_title' => 'required',
            'file_location' => 'nullable|file|mimes:pdf,jpg,jpeg,png,doc,docx|max:2048',
        ]);
    
        $promotion = Promotion::find($id);
    
        // Handle File Upload
        if ($request->hasFile('file_location')) {
            $file = $request->file('file_location');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('uploads', $fileName);
            $promotion->file_location = $filePath;
        }
    
        $promotion->update($request->all());
        return $promotion;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        return $this->promotion_service->destroy($id);
    }
}
