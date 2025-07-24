<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use App\Models\LeadsForm;
use App\Services\DynamicTableService;
use App\Models\LeadFormDetail;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Helpers\Helper;

class DynamicTableController extends Controller
{
    protected $dynamicTableService;

    public function __construct(DynamicTableService $dynamicTableService)
    {
        $this->dynamicTableService = $dynamicTableService;
    }

    public function index()
    {
        $dynamicTables = $this->dynamicTableService->getAllDynamicTables();
        return view('dynamic_table.index', compact('dynamicTables'));
    }

    public function create()
    {
        //$parents = LeadsForm::whereNull('parent_id')->pluck('form_name', 'form_id');
        $formName = LeadsForm::pluck('form_name', 'form_id');
        return view('dynamic_table.create', compact('formName'));
    }


    public function createTable(Request $request)
    {
        // Custom validation rule for snake case
        Validator::extend('snake_case', function ($attribute, $value, $parameters, $validator) {
            //return preg_match('/^[a-z]+(_[a-z]+)*$/', $value);
            return preg_match('/^[a-z0-9]+(_[a-z0-9]+)*$/', $value);
        });
    
        Validator::replacer('snake_case', function ($message, $attribute, $rule, $parameters) {
            $customAttributes = [
                'table_name' => 'Table Name',
                'fields.*.name' => 'Field Name',
            ];
    
            return str_replace(':attribute', $customAttributes[$attribute] ?? $attribute, ':attribute must be in lowercase and words should be separated by underscores(Ex.table_name).');
        });
    
        // Custom validation messages
        $messages = [
            'table_name.snake_case' => 'The :attribute must be in lowercase and words should be separated by underscores(Ex.table_name)',
            'fields.*.name.snake_case' => 'The :attribute must be in lowercase and words should be separated by underscores(Ex.first_name)',
        ];
    
        // Validate the request inputs
        $validator = Validator::make($request->all(), [
            'table_name' => 'required|string|max:255|snake_case',
            'form_id' => 'required|string|max:10',
            'fields' => 'required|array',
            'fields.*.name' => 'required|string|max:255|snake_case',
            'fields.*.type' => 'required|string|max:255',
            'fields.*.character_length' => 'nullable|string',
            'fields.*.is_index' => 'nullable|boolean',
            'fields.*.is_null' => 'nullable|boolean',
            'fields.*.is_unique' => 'nullable|boolean',
        ], $messages);
    
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
    
        $tableName = $request->input('table_name');
        $formId = $request->input('form_id');
        $viewType = $request->input('view_type');
        $formSize = $request->input('form_size');
        $fields = $request->input('fields');
    
        try {
            // Service to create the table and insert data
            $result = $this->dynamicTableService->createTable($tableName, $formId, $fields, $viewType, $formSize);
    
            if ($result === 'Table already exists.') {
                return redirect()->route('dynamictable-index')->with('error', $result);
            }
            Helper::storeLog("Dynamic Table created successfully", "Dynamic Table", "Create Dynamic Table");
    
            return redirect()->route('dynamictable-index')->with('success', 'Dynamic Table created successfully.');
        } catch (\Exception $e) {
            return redirect()->route('dynamictable-index')->with('error', 'An error occurred while creating the table: ' . $e->getMessage());
        }
    }
    


    public function show($tableName)
    {
        $dynamicTableDetails = $this->dynamicTableService->getDetailsByTableName($tableName);
        return view('dynamic_table.show', compact('dynamicTableDetails', 'tableName'));
    }

    

    public function edit($id)
    {
       
        $tableDetails = LeadFormDetail::where('table_name', $id)->get();
        // chk if the collection is empty
        if ($tableDetails->isEmpty()) {
            return redirect()->route('dynamictable-index')->with('error', 'Table not found.');
        }
        //$selectedViewType = old('view_type', 'table_view');
        //$selectedFormSize = old('form_size', '');
        $firstDetail = $tableDetails->first();
        $selectedViewType = $firstDetail->view_type ?? 'table_view'; // default to 'table_view' if not set
        $selectedFormSize = $firstDetail->form_size ?? '';           // default to empty if not set
        $formName = LeadsForm::pluck('form_name', 'form_id');
        return view('dynamic_table.edit', compact('tableDetails', 'formName', 'selectedViewType', 'selectedFormSize'));
    }

    public function update(Request $request, $id)
    {
        // Custom validation rule for snake case
        Validator::extend('snake_case', function ($attribute, $value, $parameters, $validator) {
            return preg_match('/^[a-z0-9]+(_[a-z0-9]+)*$/', $value);
        });

        Validator::replacer('snake_case', function ($message, $attribute, $rule, $parameters) {
            $customAttributes = [
                'table_name' => 'Table Name',
                'fields.*.name' => 'Field Name',
            ];

            return str_replace(':attribute', $customAttributes[$attribute] ?? $attribute, ':attribute must be in lowercase and words should be separated by underscores.');
        });

        // Custom validation messages
        $messages = [
            'table_name.snake_case' => 'The :attribute must be in lowercase and words should be separated by underscores',
            'fields.*.name.snake_case' => 'The :attribute must be in lowercase and words should be separated by underscores',
        ];

        // Validate the request inputs
        $validator = Validator::make($request->all(), [
            'table_name' => 'required|string|max:255|snake_case',
            'form_id' => 'required|string|max:10',
            'fields' => 'required|array',
            'fields.*.name' => 'required|string|max:255|snake_case',
            'fields.*.type' => 'required|string|max:255',
            'fields.*.character_length' => 'nullable|string',
            'fields.*.is_index' => 'nullable|boolean',
            'fields.*.is_null' => 'nullable|boolean',
            'fields.*.is_unique' => 'nullable|boolean',
        ], $messages);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $tableName = $request->input('table_name');
        $formId = $request->input('form_id');
        $fields = $request->input('fields');
        $viewType = $request->input('view_type');
        $formSize = $request->input('form_size');

        try {
            // Service to update the table and insert data
            $result = $this->dynamicTableService->updateTable($tableName, $formId, $fields, $id,$viewType,$formSize);

            if ($result === 'Table not found.') {
                return redirect()->route('dynamictable-index')->with('error', $result);
            }
            Helper::storeLog("Dynamic Table updated successfully", "Dynamic Table", "Edit Dynamic Table");
            return redirect()->route('dynamictable-index')->with('success', 'Dynamic Table updated successfully.');
        } catch (\Exception $e) {
            return redirect()->route('dynamictable-index')->with('error', 'An error occurred while updating the table: ' . $e->getMessage());
        }
    }

    

    public function search(Request $request)
    {
        $searchTerm = trim($request->input('search'));

        if (empty($searchTerm)) {
            return redirect()->route('dynamictable-index')->with('error', 'Search Field cannot be blank.');
        }

        $request->validate([
            'search' => 'required|string',
        ]);

        $dynamicTables = $this->dynamicTableService->searchDynamicTable($request);
        return view('dynamic_table.index', compact('dynamicTables'));
    }


    public function destroy($id)
    {   
        //dd($id);
        $this->dynamicTableService->deleteDynamicTable($id);
        Helper::storeLog("Dynamic Table deleted successfully", "Dynamic Table", "Delete Dynamic Table");
        return redirect()->route('dynamictable-index')->with('success', 'Dynamic Table deleted successfully.');
    }

}