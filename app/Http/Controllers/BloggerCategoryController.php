<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\User;
use App\Models\BloggerCategory;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\LeadsForm;
use App\Services\BloggerCategoryService;

class BloggerCategoryController extends Controller
{
    protected $cat_service;

    public function __construct(BloggerCategoryService $cat_service)
    {
        $this->cat_service = $cat_service;
    }

    public function index()
    {
        $cats = $this->cat_service->getAllCategory();
        return view('blogger_category.index', compact('cats'));
    }

    public function create()
    {
        $parents = BloggerCategory::whereNull('parent_id')->pluck('category_name', 'id');
        return view('blogger_category.create', compact('parents'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'category_name' => 'required|string|max:191',
            'category_description' => 'nullable|string',
            'category_image' => 'image|mimes:avif,jpeg,png,jpg,gif,webp|max:2048',
        ]);
        $this->cat_service->createCategory($request);

        return redirect()->route('blogger-category-list')->with('success', 'Blogger Category created successfully.');
    }

    public function show($id)
    {
        $category = $this->cat_service->get_category_details($id);
        return view('blogger_category.show', compact('category'));
    }

    public function edit($id)
    {
        $category = $this->cat_service->get_category_data($id);
        $parents = BloggerCategory::whereNull('parent_id')->pluck('category_name', 'id');
        return view('blogger_category.edit', compact('category', 'parents'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'category_name' => 'required|string|max:191',
            'category_description' => 'nullable|string',
            'category_image' => 'image|mimes:avif,jpeg,png,jpg,gif,webp|max:2048',
        ]);

        $this->cat_service->update_category($request, $id);
        return redirect()->route('blogger-category-list')->with('success', 'Blogger Category updated successfully.');
    }

    public function search(Request $request)
    {
        $searchTerm = trim($request->input('search'));
        $formName = LeadsForm::whereNull('parent_id')->pluck('form_name', 'form_id');


        if (empty($searchTerm)) {
            return redirect()->route('leadsform-index')->with('error', 'Search Field cannot be blank.');
        }

        $request->validate([
            'search' => 'required|string',
        ]);

        $leadsForms = $this->cat_service->searchLeadForm($request);
        $totalLeadsCounts = $this->getTotalLeadsCountsForForms($leadsForms);
        return view('blogger_category.index', compact('leadsForms', 'formName', 'totalLeadsCounts'));
    }


    public function destroy($id)
    {
        $this->cat_service->delete_category($id);
        return redirect()->route('blogger-category-list')->with('success', 'Blogger Category deleted successfully.');
    }

    private function getTotalLeadsCountsForForms_backup($leadsForms)
    {
        $totalLeadsCounts = [];

        foreach ($leadsForms as $form) {
            $tableNames = explode(',', $form->table_names);
            $totalCount = 0;

            foreach ($tableNames as $tableName) {
                // Chk tableName is not empty before query table data
                if (!empty($tableName)) {
                    $totalCount += DB::table($tableName)->count();
                }
            }

            $totalLeadsCounts[$form->form_id] = $totalCount;
        }

        return $totalLeadsCounts;
    }

    private function getTotalLeadsCountsForForms($leadsForms)
    {
        $totalLeadsCounts = [];

        foreach ($leadsForms as $form) {
            //total number of leads for this form_id
            $leadCount = DB::table('leads')->where('form_id', $form->form_id)->count();
            //store the count in the array with form_id as the key wise
            $totalLeadsCounts[$form->form_id] = $leadCount;
        }

        return $totalLeadsCounts;
    }

    public function updatebloggercategoryImage($id)
    {
        $category = BloggerCategory::findOrFail($id);
        if ($category->category_image) {
            // path to the image file
            $imagePath =getcwd().'/uploads/blogger_categoreis/'.$category->category_image;
            // delete the file if it exists
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
            //Update the category record to remove the profile image
            $category->category_image = null;
            $category->save();
    
            return response()->json(['success' => true]);
        }
    
        return response()->json(['success' => false, 'message' => 'No category image found']);
    }

}
