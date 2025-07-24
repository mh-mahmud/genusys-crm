<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\LeadsForm;
use App\Models\LeadFormDetail;
use App\Models\Lead;
use App\Services\LeadService;

class LeadController  extends Controller
{
    protected $leadService;

    public function __construct(LeadService  $leadService)
    {
        $this->leadService = $leadService;
    }


    public function index()
    {
        $leads = $this->leadService->getAllLeads();
        //$formName = LeadsForm::pluck('form_name', 'form_id');
        $formName = LeadsForm::whereNull('parent_id')->pluck('form_name', 'form_id');
        return view('leads.index', compact('leads', 'formName'));
    }

    public function create_backup()
    {

        return view('leads.create');
    }

    public function create(Request $request)
    {
        //dd('sdsd');die();
        $formName = [
            1 => 'Form A',
            2 => 'Form B',

        ];

        $fieldsByTable = [];

        if ($request->has('form_id')) {
            $formId = $request->input('form_id');
            $fields = LeadFormDetail::where('form_id', $formId)->get();

            foreach ($fields as $field) {
                $fieldsByTable[$field->table_name][] = $field;
            }
        }

        return view('leads.create', compact('formName', 'fieldsByTable'));
    }



    public function store_backup(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:191',
            'last_name' => 'required|string|max:191',
            'title' => 'required|string|max:191',
            'email' => 'nullable|string|email|max:191|unique:leads,email',
            'phone' => 'required|string|max:191',

        ]);

        $data = $request->all();
        $this->leadService->createLead($data);

        return redirect()->route('lead-index')->with('success', 'Lead created successfully.');
    }

    public function store(Request $request)
    {

        $request->validate([
            'first_name' => 'required|string|max:191',
            'last_name' => 'required|string|max:191',
            'title' => 'required|string|max:191',
            'email' => 'nullable|string|email|max:191|unique:leads,email',
            'phone' => 'required|string|max:191',
            'form_id' => 'required|exists:leads_form,form_id',
        ]);
        //dd($request);die();

        //$data = $request->only(['first_name', 'last_name', 'title', 'email', 'phone', 'lead_status','form_id']);
        $data = $request->all();

        $dynamicFields = $request->except(['first_name', 'last_name', 'title', 'email', 'phone', 'form_id', '_token']);
        //dd($dynamicFields);die();



        $this->leadService->createLead($data, $request->input('form_id'), $dynamicFields);

        return redirect()->route('lead-index')->with('success', 'Lead created successfully.');
    }


    public function show_backup($id)
    {
        $lead = $this->leadService->getLeadById($id);
        return view('leads.show', compact('lead'));
    }

    public function show($id)
    {
        $lead = $this->leadService->getLeadById($id);

        // Fetch dynamic fields data based on lead_id
        $fields = LeadFormDetail::where('form_id', $lead->form_id)->get();
        $tableData = [];
        foreach ($fields as $field) {
            $tableName = $field->table_name;
            $tableData[$tableName] = DB::table($tableName)->where('lead_id', $lead->id)->first();
        }

        return view('leads.show', compact('lead', 'tableData'));
    }



    public function edit_backup($id)
    {
        $formName = LeadsForm::pluck('form_name', 'form_id');
        $lead = $this->leadService->getLeadById($id);
        return view('leads.edit', compact('lead', 'formName'));
    }

    public function edit($id)
    {
        //$formName = LeadsForm::pluck('form_name', 'form_id');
        $formName = LeadsForm::whereNull('parent_id')->pluck('form_name', 'form_id');
        $lead = $this->leadService->getLeadById($id);
        $fieldsByTable = [];
        $tableData = [];

        if ($lead->form_id) {
            $formId = $lead->form_id;
            $fields = LeadFormDetail::where('form_id', $formId)->get();

            foreach ($fields as $field) {
                $fieldsByTable[$field->table_name][] = $field;

                // specific table based on lead_id
                if (!isset($tableData[$field->table_name])) {
                    $tableData[$field->table_name] = DB::table($field->table_name)->where('lead_id', $lead->id)->first();
                }
            }
        }

        return view('leads.edit', compact('lead', 'formName', 'fieldsByTable', 'tableData'));
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'first_name' => 'required|string|max:191',
            'last_name' => 'required|string|max:191',
            'title' => 'required|string|max:191',
            'email' => 'nullable|string|email|max:191|unique:leads,email,' . $id,
            'phone' => 'required|string|max:191',
            'form_id' => 'required|exists:leads_form,form_id',
        ]);

        $data = $request->all();
        $dynamicFields = $request->except(['first_name', 'last_name', 'title', 'email', 'phone', 'form_id', '_token']);

        $this->leadService->updateLead($id, $data, $request->input('form_id'), $dynamicFields);

        return redirect()->route('lead-index')->with('success', 'Lead updated successfully.');
    }


    public function search(Request $request)
    {
        $searchTerm = trim($request->input('search'));
        $formName = LeadsForm::pluck('form_name', 'form_id');

        if (empty($searchTerm)) {
            return redirect()->route('lead-index')->with('error', 'Search Field cannot be blank.');
        }

        $request->validate([
            'search' => 'required|string',
        ]);

        $leads = $this->leadService->searchLeadForm($request);
        return view('leads.index', compact('leads', 'formName'));
    }

    public function destroy($id)
    {
        $this->leadService->deleteLead($id);
        return redirect()->route('lead-index')->with('success', 'Lead deleted successfully.');
    }




    public function leads_upload_backup(Request $request)
    {
        //dd($request->form_id);die();
        $formName = [
            1 => 'Form A',
            2 => 'Form B',

        ];

        $fieldsByTable = [];
        $formId = $request->input('form_id');

        if ($request->has('form_id')) {
            $formId = $request->input('form_id');
            $fields = LeadFormDetail::where('form_id', $formId)->get();

            foreach ($fields as $field) {
                $fieldsByTable[$field->table_name][] = $field;
            }
        }

        return view('leads.leads_upload', compact('formName', 'fieldsByTable', 'formId'));
    }


    public function leads_upload(Request $request)
    {
        $formId = $request->input('form_id');
        return view('leads.leads_upload', compact('formId'));
    }


    public function downloadSampleFile_backup(Request $request)
    {
        // Validate the request
        $request->validate([
            'form_id' => 'required|exists:leads_form,form_id'
        ]);
        $leadFormDetailsColumns = LeadFormDetail::where('form_id', $request->form_id)->pluck('field_name')->toArray();
        // Get columns from Lead table
        $leadColumns = (new Lead)->getFillable();

        //Merge columns ensuring no duplicates
        $columns = array_unique(array_merge($leadColumns, $leadFormDetailsColumns));
        $columns = array_filter($columns, function ($column) {
            return $column !== 'form_id' && $column !== 'parent_id';
        });

        //dd($columns);die();
        $callback = function () use ($columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);
            fclose($file);
        };

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="sample-file.csv"',
        ];

        return Response::stream($callback, 200, $headers);
    }


    public function downloadSampleFile(Request $request)
    {
        // Validate the request
        $request->validate([
            'form_id' => 'required|exists:leads_form,form_id'
        ]);
        $leadFormDetailsColumns = LeadFormDetail::where('form_id', $request->form_id)->pluck('field_name')->toArray();
        // Get columns from Lead table
        $leadColumns = (new Lead)->getFillable();

        //Merge columns ensuring no duplicates
        $columns = array_unique(array_merge($leadColumns, $leadFormDetailsColumns));
        $columns = array_filter($columns, function ($column) {
            return $column !== 'form_id' && $column !== 'parent_id';
        });

        // Map columns to user-friendly names
        $formattedColumns = array_map(function ($column) {
            return ucwords(str_replace('_', ' ', $column));
        }, $columns);

        $callback = function () use ($formattedColumns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $formattedColumns);
            fclose($file);
        };

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="sample-file.csv"',
        ];

        return Response::stream($callback, 200, $headers);
    }

    public function upload_file_backup(Request $request)
    {
        // Custom validation messages
        $messages = [
            'fileUpload.required' => 'The file upload is required.',
            'fileUpload.file' => 'The uploaded file must be a valid file.',
            'fileUpload.mimes' => 'The uploaded file must be a file of type: csv, txt.',
            'form_id.required' => 'The form ID is required.',
            'form_id.exists' => 'The selected form ID is invalid.',
        ];

        // Validate the request
        $validator = Validator::make($request->all(), [
            'fileUpload' => 'required|file|mimes:csv,txt',
            'form_id' => 'required|exists:leads_form,form_id'
        ], $messages);

        if ($validator->fails()) {
            // Collect validation error messages
            $errorMessages = implode(' ', $validator->errors()->all());
            return redirect()->back()->with('error', $errorMessages)->withInput();
        }

        $formId = $request->input('form_id');
        $parentId = DB::table('leads_form')->where('form_id', $formId)->value('parent_id');

        //uploaded file code
        if ($request->hasFile('fileUpload')) {
            $file = $request->file('fileUpload');
            $path = $file->getRealPath();

            // Open and read the CSV file
            $handle = fopen($path, 'r');
            $header = fgetcsv($handle, 1000, ',');

            // Check if the header matches the expected columns
            if ($header && count($header) > 0) {
                // Get fields configuration from LeadFormDetail
                $fieldsConfig = LeadFormDetail::where('form_id', $formId)->get()->groupBy('table_name');

                // Begin a database transaction
                DB::beginTransaction();

                try {
                    $errors = []; // To collect validation errors

                    while (($data = fgetcsv($handle, 1000, ',')) !== FALSE) {
                        $csvData = array_combine($header, $data);

                        // Validate required fields and unique email
                        $validator = Validator::make($csvData, [
                            'first_name' => 'required|string|max:191',
                            'last_name' => 'required|string|max:191',
                            'title' => 'required|string|max:191',
                            'email' => 'nullable|string|email|max:191|unique:leads,email',
                            'phone' => 'required|string|max:191',
                        ]);

                        if ($validator->fails()) {
                            $errors[] = $validator->errors()->all();
                            continue; // Skip to next iteration if validation fails
                        }

                        // Insert data into the Lead table
                        $leadData = [];
                        foreach ((new Lead)->getFillable() as $field) {
                            if (isset($csvData[$field])) {
                                //empty strings and set to NULL if empty
                                $leadData[$field] = $csvData[$field] === '' ? NULL : $csvData[$field];
                            }
                        }

                        $leadData['form_id'] = $formId;
                        $leadData['lead_status'] = '1';
                        $leadId = DB::table('leads')->insertGetId($leadData);
                        if (!$leadId) {
                            throw new \Exception("Failed to insert lead data and retrieve lead ID.");
                        }

                        // Insert data into the respective tables based on the configuration
                        foreach ($fieldsConfig as $tableName => $fields) {
                            $insertData = [
                                'lead_id' => $leadId,
                                'form_id' => $formId,
                            ];
                            if ($parentId !== null) {
                                $insertData['parent_id'] = $parentId;
                            }

                            foreach ($fields as $field) {
                                if (isset($csvData[$field->field_name])) {
                                    // Check for empty strings and set to NULL if empty
                                    $insertData[$field->field_name] = $csvData[$field->field_name] === '' ? NULL : $csvData[$field->field_name];
                                }
                            }

                            if (!empty($insertData)) {
                                DB::table($tableName)->insert($insertData);
                            }
                        }
                    }

                    fclose($handle);

                    // Commit the transaction
                    DB::commit();

                    if (!empty($errors)) {
                        return redirect()->back()->with('error', 'Validation failed for some records. Errors:' . json_encode($errors));
                    } else {
                        return redirect()->back()->with('success', 'File uploaded and data inserted successfully.');
                    }
                } catch (\Exception $e) {
                    // Rollback the transaction if something goes wrong
                    DB::rollback();

                    return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage());
                }
            } else {
                return redirect()->back()->with('error', 'Invalid CSV file format.');
            }
        } else {
            return redirect()->back()->with('error', 'File not uploaded.');
        }
    }



    public function upload_file(Request $request)
    {
        // Custom validation messages
        $messages = [
            'fileUpload.required' => 'The file upload is required.',
            'fileUpload.file' => 'The uploaded file must be a valid file.',
            'fileUpload.mimes' => 'The uploaded file must be a file of type: csv, txt.',
            'form_id.required' => 'The form ID is required.',
            'form_id.exists' => 'The selected form ID is invalid.',
        ];

        // Validate the request
        $validator = Validator::make($request->all(), [
            'fileUpload' => 'required|file|mimes:csv,txt',
            'form_id' => 'required|exists:leads_form,form_id'
        ], $messages);

        if ($validator->fails()) {
            // Collect validation error messages
            $errorMessages = implode(' ', $validator->errors()->all());
            return redirect()->back()->with('error', $errorMessages)->withInput();
        }

        $formId = $request->input('form_id');
        $parentId = DB::table('leads_form')->where('form_id', $formId)->value('parent_id');

        // Uploaded file code
        if ($request->hasFile('fileUpload')) {
            $file = $request->file('fileUpload');
            $path = $file->getRealPath();

            // Open and read CSV file
            $handle = fopen($path, 'r');
            $header = fgetcsv($handle, 1000, ',');

            //header to convert spaces to underscores and uppercase to lowercase
            $dbHeader = array_map(function ($column) {
                $column = str_replace(' ', '_', $column);
                $column = strtolower($column);
                return $column;
            }, $header);

            // Check if the header matches the expected columns
            if ($dbHeader && count($dbHeader) > 0) {
                // Get fields from LeadFormDetail
                $fieldsConfig = LeadFormDetail::where('form_id', $formId)->get()->groupBy('table_name');

                // Collect all CSV data and validation errors
                $allCsvData = [];
                $errors = []; //collect validation errors
                $rowNumber = 2; // Start from the second row because the first row is the header

                while (($data = fgetcsv($handle, 1000, ',')) !== FALSE) {
                    $csvData = array_combine($dbHeader, $data);

                    // Validate required fields and unique email
                    $validator = Validator::make($csvData, [
                        'first_name' => 'required|string|max:191',
                        'last_name' => 'required|string|max:191',
                        'title' => 'required|string|max:191',
                        'email' => 'nullable|string|email|max:191|unique:leads,email',
                        'phone' => 'required|string|max:191',
                    ]);

                    if ($validator->fails()) {
                        $errors[] = ['row' => $rowNumber, 'messages' => $validator->errors()->all()];
                    } else {
                        $allCsvData[] = $csvData; // Only collect valid data
                    }
                    $rowNumber++;
                }

                fclose($handle);

                if (!empty($errors)) {
                    $errorMessages = [];
                    foreach ($errors as $error) {
                        $errorMessages[] = 'Row ' . $error['row'] . ': ' . implode(' ', $error['messages']);
                    }
                    return redirect()->back()->with('error', 'Validation failed for some records. Errors:' . json_encode($errorMessages));
                }

                // Begin a database transaction
                DB::beginTransaction();

                try {
                    $insertedCount = 0; // count the number of successfully inserted data

                    foreach ($allCsvData as $csvData) {
                        // insert data into the Lead table
                        $leadData = [];
                        foreach ((new Lead)->getFillable() as $field) {
                            if (isset($csvData[$field])) {
                                // Empty strings and set to NULL if empty
                                $leadData[$field] = $csvData[$field] === '' ? NULL : $csvData[$field];
                            }
                        }

                        $leadData['form_id'] = $formId;
                        $leadData['lead_status'] = '1';
                        $leadId = DB::table('leads')->insertGetId($leadData);
                        if (!$leadId) {
                            throw new \Exception("Failed to insert lead data and retrieve lead ID.");
                        }

                        // Insert data into the tables based on the config
                        foreach ($fieldsConfig as $tableName => $fields) {
                            $insertData = [
                                'lead_id' => $leadId,
                                'form_id' => $formId,
                            ];
                            if ($parentId !== null) {
                                $insertData['parent_id'] = $parentId;
                            }

                            foreach ($fields as $field) {
                                if (isset($csvData[$field->field_name])) {
                                    // Check for empty strings and set to NULL if empty
                                    $insertData[$field->field_name] = $csvData[$field->field_name] === '' ? NULL : $csvData[$field->field_name];
                                }
                            }

                            if (!empty($insertData)) {
                                DB::table($tableName)->insert($insertData);
                            }
                        }

                        // Increment the count of successfully inserted records
                        $insertedCount++;
                    }

                    // Commit the transaction
                    DB::commit();

                    return redirect()->back()->with('success', "File uploaded and data inserted successfully. Number of records inserted: $insertedCount.");
                } catch (\Exception $e) {
                    // Rollback the transaction if something goes wrong error
                    DB::rollback();

                    return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage());
                }
            } else {
                return redirect()->back()->with('error', 'Invalid CSV file format.');
            }
        } else {
            return redirect()->back()->with('error', 'File not uploaded.');
        }
    }
    






}
