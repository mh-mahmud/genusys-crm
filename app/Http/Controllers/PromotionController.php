<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\Promotion;
use App\Services\PromotionService;

class PromotionController extends Controller
{
    protected $promotionService;

    public function __construct(PromotionService $promotionService)
    {
        $this->promotionService = $promotionService;
    }

    public function index()
    {
        $promotions = $this->promotionService->getAllPromotion();
        return view('promotion.index', compact('promotions'));
    }

    public function create()
    {   
       
        return view('promotion.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'promotion_title' => 'required',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'file_location' => 'nullable|file|mimes:pdf,jpg,jpeg,png,doc,docx,xlsx,csv|max:2048',
           
        ]);
        //dd($request);die();
        // Handle the file upload
         $data = $request->all();
         if ($request->hasFile('file_location')) {
             $data['file_location'] = $request->file('file_location');
         }

        $this->promotionService->createPromotion($request->all());

        return redirect()->route('promotion-index')->with('success', 'Promotion created successfully.');
    }

    public function show($id)
    {
        $promotion = $this->promotionService->getPromotionById($id);
        return view('promotion.show', compact('promotion'));
    }

    public function edit($id)
    {
        $promotion = $this->promotionService->getPromotionById($id);
        return view('promotion.edit', compact('promotion'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'promotion_title' => 'required',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'file_location' => 'nullable|file|mimes:pdf,jpg,jpeg,png,doc,docx,xlsx,csv|max:2048',
           
        ]);

        $data = $request->all();
        if ($request->hasFile('file_location')) {
            $data['file_location'] = $request->file('file_location');
        }

        $this->promotionService->updatePromotion($id, $request->all());

        return redirect()->route('promotion-index')->with('success', 'Promotion updated successfully.');
    }

    public function search(Request $request)
    {
        $searchTerm = trim($request->input('search'));

        if (empty($searchTerm)) {
            return redirect()->route('promotion-index')->with('error', 'Search Field cannot be blank.');
        }

        $request->validate([
            'search' => 'required|string',
        ]);

        $promotions = $this->promotionService->searchPromotion($request);
        return view('promotion.index', compact('promotions'));
    }


    public function destroy($id)
    {
        $this->promotionService->deletePromotion($id);
        return redirect()->route('promotion-index')->with('success', 'Promotion deleted successfully.');
    }
}