<?php

namespace App\Services;

use App\Models\DriverInformation;
use App\Models\Lead;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\LeadFormDetail;
use App\Models\VehicleInformation;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Auth;

class LeadService
{
    public function getAllLeads_backup()
    {

        if (Auth::user()->user_type !== 'admin') {
            return Lead::with('leadsForm:form_id,form_name')->where('created_by', Auth::user()->id)->orderBy('id', 'desc')->paginate(config('constants.ROW_PER_PAGE'));
        } else {
            return Lead::with('leadsForm:form_id,form_name')->where('lead_rating', '!=', 10)->orderBy('id', 'desc')->paginate(config('constants.ROW_PER_PAGE'));
        }
    }
	
	public function getAllLeads() {
        //  return Lead::with('leadsForm:form_id,form_name')->where('lead_rating', '=', null)->orderBy('id', 'desc')->paginate(config('constants.ROW_PER_PAGE'));
        $query = Lead::with('leadsForm:form_id,form_name')->where('lead_rating', '=', null);
        if (!Auth::user()->hasPermission('can-see-leads')) {
            $query->where('created_by', Auth::id());

        }

         return $query->orderBy('id', 'desc')->paginate(config('constants.ROW_PER_PAGE'));

    }

    public function getTotalLeads()
    {
        return Lead::with('leadsForm:form_id,form_name')
            ->leftJoin('customers', 'leads.id', '=', 'customers.lead_id')
            ->whereNull('customers.lead_id')
            ->select('leads.*') 
            ->orderBy('leads.id', 'desc')
            ->paginate(config('constants.ROW_PER_PAGE')); 
    }

   public function getLeadsByFormId($form_id)
    {
        if (Auth::user()->user_type !== 'admin') {
            return Lead::where('form_id', $form_id)->orderBy('id', 'desc')->paginate(config('constants.ROW_PER_PAGE'));
        } else {
            return Lead::where('form_id', $form_id)->where('created_by', Auth::user()->id)->orderBy('id', 'desc')->paginate(config('constants.ROW_PER_PAGE'));
        }
    }
    public function getLeadById($id)
    {
        return Lead::findOrFail($id);
    }


    public function createLead_backup($data, $formId, $dynamicFields)
    {

        $lead = Lead::create($data);
        $fields = LeadFormDetail::where('form_id', $formId)->get();
        $tableData = [];
        //fields and prepare data
        foreach ($fields as $field) {
            $fieldName = $field->field_name;
            $tableName = $field->table_name;

            // table data
            if (!isset($tableData[$tableName])) {
                $tableData[$tableName] = [
                    'lead_id' => $lead->id,
                    'form_id' => $formId,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
            // Add field value table data array
            if (isset($dynamicFields[$fieldName])  && !empty($dynamicFields[$fieldName])) {
                $tableData[$tableName][$fieldName] = $dynamicFields[$fieldName];
            } else {
                // missing field default value
                if ($field->field_value == 'varchar' || $field->field_value == 'char' || $field->field_value == 'text'|| $field->field_value == 'file'|| $field->field_value == 'dropdown') {
                    $tableData[$tableName][$fieldName] = '';
                } elseif ($field->field_value == 'int') {
                    $tableData[$tableName][$fieldName] = 0;
                } elseif ($field->field_value == 'date') {
                    $tableData[$tableName][$fieldName] = '';
                } else {
                    $tableData[$tableName][$fieldName] = null;
                }
            }
        }

        //dynamic table data insert
        foreach ($tableData as $tableName => $data) {
            // Check if there are any dynamic fields with values to insert
            $hasDynamicFields = collect($data)->filter(function ($value, $key) {
                return !in_array($key, ['lead_id', 'form_id', 'created_at', 'updated_at']) && !empty($value);
            })->isNotEmpty();
            // Insert data fields with values to insert
            if ($hasDynamicFields) {
                DB::table($tableName)->insert($data);
            }
        }


        return $lead;
    }


    public function createLead_without_integer_validation($data, $formId, $dynamicFields, $request)
    {
        //dd($data);

        if ($request->hasFile('profile_image')) {
            $fileNameWithExt = $request->file('profile_image')->getClientOriginalName();
            $fileName = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
            $extension = $request->file('profile_image')->getClientOriginalExtension();
            $fileNameToStore = $fileName.'_'.time().'.'.$extension;
            $path = $request->file('profile_image')->move(getcwd().'/uploads/leads', $fileNameToStore);
            
        } else {
            
            $fileNameToStore = '';
        }

        $data['profile_image'] = $fileNameToStore;

        $lead = Lead::create($data);
        $fields = LeadFormDetail::where('form_id', $formId)->get();
        // dd($fields);
        $tableData = [];

        // prepare fields and data
        foreach ($fields as $field) {
            $fieldName = $field->field_name;
            $tableName = $field->table_name;

            // initialize table data array
            if (!isset($tableData[$tableName])) {
                $tableData[$tableName] = [
                    'lead_id' => $lead->id,
                    'form_id' => $formId,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }

            // handle file upload
            if ($field->field_value === 'file' && $request->hasFile($fieldName)) {
                $fileNameWithExt = $request->file($fieldName)->getClientOriginalName();
                $fileName = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
                $extension = $request->file($fieldName)->getClientOriginalExtension();
                $fileNameToStore = $fileName . '_' . time() . '.' . $extension;
                //$request->file($fieldName)->move(public_path('uploads/files'), $fileNameToStore);
                $request->file($fieldName)->move(getcwd() . '/uploads/files', $fileNameToStore);
                $tableData[$tableName][$fieldName] = $fileNameToStore;
            }
            // add dynamic field data to the table data array
            elseif (isset($dynamicFields[$fieldName]) && !empty($dynamicFields[$fieldName])) {
                $tableData[$tableName][$fieldName] = $dynamicFields[$fieldName];
            }
            // handle default values for missing fields
            else {
                if (in_array($field->field_value, ['varchar', 'char', 'text', 'file'])) {
                    $tableData[$tableName][$fieldName] = '';
                } elseif ($field->field_value == 'int') {
                    $tableData[$tableName][$fieldName] = 0;
                } elseif ($field->field_value == 'date') {
                    $tableData[$tableName][$fieldName] = null;
                }elseif ($field->field_value == 'dropdown') {
                    $tableData[$tableName][$fieldName] = null;
                } else {
                    $tableData[$tableName][$fieldName] = null;
                }
            }
        }


        // insert dynamic table data
        foreach ($tableData as $tableName => $data) {
            // chk if there are any dynamic fields with values to insert
            $hasDynamicFields = collect($data)->filter(function ($value, $key) {
                return !in_array($key, ['lead_id', 'form_id', 'created_at', 'updated_at']) && !empty($value);
            })->isNotEmpty();
            // insert data fields with values to insert
            if ($hasDynamicFields) {
                DB::table($tableName)->insert($data);
            }
        }

        return $lead;
    }





    public function createLead($data, $formId, $dynamicFields, $request)
    {
        $fields = LeadFormDetail::where('form_id', $formId)->get();
        $rules = [];
        $messages = [];

        $request->validate([
            // 'first_name' => 'required|unique:leads,first_name'
            'first_name' => 'required'

        ]);

        // prepare validation rules based on the form fields
        foreach ($fields as $field) {
            $fieldName = $field->field_name;

            if ($field->field_value == 'int') {
                // define rules for integer fields with a maximum of 10 digits
                $rules[$fieldName] = 'nullable|integer|digits_between:1,10';
                $messages["{$fieldName}.digits_between"] = "{$fieldName} must be between 1 and 10 digits.";
            }

            // add other field validations as necessary (example for strings,files)
        }

        // Validate the dynamic fields data against the rules
        $validator = Validator::make($dynamicFields, $rules, $messages);

        if ($validator->fails()) {
            // Throw validation error with custom message
            throw new ValidationException($validator);
        }

        // handle the profile image separately
        if ($request->hasFile('profile_image')) {
            $fileNameWithExt = $request->file('profile_image')->getClientOriginalName();
            $fileName = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
            $extension = $request->file('profile_image')->getClientOriginalExtension();
            $fileNameToStore = $fileName . '_' . time() . '.' . $extension;
            $path = $request->file('profile_image')->move(getcwd() . '/uploads/leads', $fileNameToStore);

            $data['profile_image'] = $fileNameToStore;
        } else {
            $data['profile_image'] = '';
        }

        // create the lead data
        DB::beginTransaction();
        $data['created_by'] = Auth::user()->id;
        $lead = Lead::create($data);
        $tableData = [];

        // prepare fields and data for insertion into dynamic tables
        foreach ($fields as $field) {
            $fieldName = $field->field_name;
            $tableName = $field->table_name;

            // Initialize table data array
            if (!isset($tableData[$tableName])) {
                $tableData[$tableName] = [
                    'lead_id' => $lead->id,
                    'form_id' => $formId,
                    'created_by' => Auth::user()->username,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }

            // handle file upload for dynamic fields
            if ($field->field_value === 'file' && $request->hasFile($fieldName)) {
                $fileNameWithExt = $request->file($fieldName)->getClientOriginalName();
                $fileName = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
                $extension = $request->file($fieldName)->getClientOriginalExtension();
                $fileNameToStore = $fileName . '_' . time() . '.' . $extension;
                $request->file($fieldName)->move(getcwd() . '/uploads/files', $fileNameToStore);
                $tableData[$tableName][$fieldName] = $fileNameToStore;
            }
            // add dynamic field data to the table data array
            elseif (isset($dynamicFields[$fieldName]) && !empty($dynamicFields[$fieldName])) {
                $tableData[$tableName][$fieldName] = $dynamicFields[$fieldName];
            }
            // handle default values for missing fields
            else {
                if (in_array($field->field_value, ['varchar', 'char', 'text', 'file'])) {
                    $tableData[$tableName][$fieldName] = '';
                } elseif ($field->field_value == 'int') {
                    $tableData[$tableName][$fieldName] = 0;
                } elseif ($field->field_value == 'date') {
                    $tableData[$tableName][$fieldName] = null;
                } elseif ($field->field_value == 'dropdown') {
                    $tableData[$tableName][$fieldName] = null;
                } else {
                    $tableData[$tableName][$fieldName] = null;
                }
            }
        }

        // insert dynamic table data
        foreach ($tableData as $tableName => $data) {
            // chk if there are any dynamic fields with values to insert
            $hasDynamicFields = collect($data)->filter(function ($value, $key) {
                return !in_array($key, ['lead_id', 'form_id','created_by', 'created_at', 'updated_at']) && !empty($value);
            })->isNotEmpty();
            if($tableName == "vehicle_attributes") {
                $data["vehicle_info_id"] = VehicleInformation::where("lead_id", $lead->id)
                                                    ->value('id');
                
            } else if($tableName == "driver_attributes") {
                $data["driver_info_id"] = DriverInformation::where("lead_id", $lead->id)
                                                    ->value('id');
                
            }

            // insert data fields with values to insert
            if ($hasDynamicFields) {
                DB::table($tableName)->insert($data);
            }
        }
        DB::commit();

        return $lead;
    }





    public function updateLead_backup($id, $data, $formId, $dynamicFields)
    {
        $lead = Lead::findOrFail($id);
        $lead->update($data);

        $fields = LeadFormDetail::where('form_id', $formId)->get();
        $tableData = [];

        foreach ($fields as $field) {
            $fieldName = $field->field_name;
            $tableName = $field->table_name;

            if (!isset($tableData[$tableName])) {
                $tableData[$tableName] = [
                    'lead_id' => $lead->id,
                    'form_id' => $formId,
                    'updated_at' => now(),
                ];
            }

            if (isset($dynamicFields[$fieldName]) && !empty($dynamicFields[$fieldName])) {
                $tableData[$tableName][$fieldName] = $dynamicFields[$fieldName];
            } else {
                if ($field->field_value == 'varchar' || $field->field_value == 'char' || $field->field_value == 'text') {
                    $tableData[$tableName][$fieldName] = '';
                } elseif ($field->field_value == 'int') {
                    $tableData[$tableName][$fieldName] = 0;
                } elseif ($field->field_value == 'date') {
                    $tableData[$tableName][$fieldName] = date('Y-m-d');
                } else {
                    $tableData[$tableName][$fieldName] = null;
                }
            }
        }

        foreach ($tableData as $tableName => $data) {
            $hasDynamicFields = collect($data)->filter(function ($value, $key) {
                return !in_array($key, ['lead_id', 'form_id', 'created_at', 'updated_at']) && !empty($value);
            })->isNotEmpty();

            if ($hasDynamicFields) {
                DB::table($tableName)->updateOrInsert(['lead_id' => $lead->id], $data);
            }
        }

        return $lead;
    }

    public function updateLead($id, $data, $request)
    {

        if ($request->hasFile('profile_image')) {

            $fileNameWithExt = $request->file('profile_image')->getClientOriginalName();
            $fileName = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
            $extension = $request->file('profile_image')->getClientOriginalExtension();
            $fileNameToStore = $fileName.'_'.time().'.'.$extension;
            $path = $request->file('profile_image')->move(getcwd().'/uploads/leads', $fileNameToStore);
            $data['profile_image'] = $fileNameToStore;

            // remove previous image
            $image = Lead::where('id', $id)->first(['profile_image']);
            if(!empty($image->profile_image)) {
                $path_kaka = getcwd().'/uploads/leads/'.$image->profile_image;
                @unlink($path_kaka);
            }
        }

        $lead = Lead::findOrFail($id);
        $lead->update($data);
        return $lead;
    }

    public function getTableData_backup($tableName, $leadId)
    {
        //get column names
        $columns = Schema::getColumnListing($tableName);

        //fetch lead form details
        $fields = DB::table('lead_form_details')
            ->where('table_name', $tableName)
            ->first();

        //fetch lead details with the lead ID
        //$leads = DB::table('leads')
        //->where('id', $leadId)
        // ->first();

        $leads = DB::table($tableName)
        ->where('id', $leadId)
            ->first();

        //fetch column details with data types using 
        $columnDetails = DB::select("SHOW COLUMNS FROM $tableName");

        //column map names to their types
        $columnTypes = [];
        foreach ($columnDetails as $column) {
            $columnName = $column->Field;
            $columnType = $column->Type;
            $columnTypes[$columnName] = $columnType;
        }

        //filter out unwanted fields
        $filteredColumns = array_filter($columns, function ($column) {
            return !in_array($column, ['id', 'created_at', 'updated_at']);
        });

        //fetch existing data
        $existingData = DB::table($tableName)
            ->where('id', $leadId)
            ->first();

        return [
            'tableName' => $tableName,
            'filteredColumns' => $filteredColumns,
            'leads' => $leads,
            'columnTypes' => $columnTypes,
            'existingData' => $existingData,
        ];
    }


    public function getTableData($tableName, $leadId)
    {
        //get column names
        $columns = Schema::getColumnListing($tableName);

        //fetch lead form details
        $fields = DB::table('lead_form_details')
            ->where('table_name', $tableName)
            ->get();

        //fetch lead details with the lead ID
        $leads = DB::table($tableName)
            ->where('id', $leadId)
            ->first();

        //fetch column details with data types using 
        $columnDetails = DB::select("SHOW COLUMNS FROM $tableName");

        //column map names to their types
        $columnTypes = [];
        $dropdownOptions = [];
        foreach ($columnDetails as $column) {
            $columnName = $column->Field;
            $columnType = $column->Type;
            // Check if the field_value in $fields is 'file' and override the type
            foreach ($fields as $field) {
                if ($field->field_value == 'file' && $columnName == $field->field_name) {
                    $columnType = 'file';
                    break;
                }elseif ($field->field_value == 'dropdown' && $columnName == $field->field_name) {
                    $columnType = 'dropdown';
                     // split the character length field into an array if it is a dropdown list
                    if (!empty($field->character_length)) {
                        $dropdownOptions[$columnName] = explode(',', $field->character_length);
                    }
                    break;
                }
            }
            $columnTypes[$columnName] = $columnType;
        }

        //filter out unwanted fields
        $filteredColumns = array_filter($columns, function ($column) {
            return !in_array($column, ['id','created_by', 'created_at', 'updated_at']);
        });

        //fetch existing data
        $existingData = DB::table($tableName)
            ->where('id', $leadId)
            ->first();

        return [
            'tableName' => $tableName,
            'filteredColumns' => $filteredColumns,
            'leads' => $leads,
            'columnTypes' => $columnTypes,
            'dropdownOptions' =>$dropdownOptions,
            'existingData' => $existingData,
        ];
    }

    public function updateTableData($request, $tableName, $leadId, $formId, $formData)
    {

        if (!Schema::hasTable($tableName)) {
            throw new \Exception('Table does not exist.');
        }
        if (Schema::hasColumn($tableName, 'updated_at')) {
            $formData['updated_at'] = now();
        }
        if (Schema::hasColumn($tableName, 'created_by')) {
            $formData['created_by'] = Auth::user()->username;
        }
        $existingData = DB::table($tableName)
            ->where('id', $leadId)
            ->where('form_id', $formId)
            ->first();

        if (!$existingData) {
            throw new \Exception('Record not found.');
        }
        $fields = LeadFormDetail::where('table_name', $tableName)->get();
        $rules = [];
        $messages = [];
        foreach ($fields as $field) {
            $columnName = $field->field_name;

            // chk if the field is a file input
            if ($field->field_value === 'file' && $request->hasFile($columnName)) {
                // delete the old file
                if (!empty($existingData->$columnName)) {
                    $oldFilePath = getcwd() . '/uploads/files/' . $existingData->$columnName;
                    if (file_exists($oldFilePath)) {
                        @unlink($oldFilePath); // delete the old file
                    }
                }

                //uploadfile
                $fileNameWithExt = $request->file($columnName)->getClientOriginalName();
                $fileName = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
                $extension = $request->file($columnName)->getClientOriginalExtension();
                $fileNameToStore = $fileName . '_' . time() . '.' . $extension;
                $request->file($columnName)->move(getcwd() . '/uploads/files', $fileNameToStore);
                // store the new file name in the formData array
                $formData[$columnName] = $fileNameToStore;
            }
            // integer validation
            if ($field->field_value == 'int') {
                $rules[$columnName] = 'nullable|integer|digits_between:1,10';
                $messages["{$columnName}.digits_between"] = ucwords(str_replace('_', ' ', $columnName)) . " must be between 1 and 10 digits.";
            }
        }

        // Validate the formData against the rules
        $validator = Validator::make($formData, $rules, $messages);

        if ($validator->fails()) {
            // Throw validation error with custom message
            throw new ValidationException($validator);
        }

        // update the custom table data
        DB::table($tableName)
            ->where('id', $leadId)
            ->where('form_id', $formId)
            ->update($formData);
    }
    

    public function searchLeadForm($request)
    {
        $searchTerm = trim($request->input('search'));

        $query = Lead::query();
        //dd($query);die();
        $query->where(function ($q) use ($searchTerm) {
            $q->where('title', 'LIKE', '%' . $searchTerm . '%')
                ->orWhere('first_name', 'LIKE', '%' . $searchTerm . '%')
                ->orWhere('last_name', 'LIKE', '%' . $searchTerm . '%')
                ->orWhere('email', 'LIKE', '%' . $searchTerm . '%')
                ->orWhere('phone', 'LIKE', '%' . $searchTerm . '%')
                ->orWhere('gender', 'LIKE', '%' . $searchTerm . '%')
                ->orWhere('dob', 'LIKE', '%' . $searchTerm . '%')
                ->orWhere('age', 'LIKE', '%' . $searchTerm . '%')
                ->orWhere('lead_rating', 'LIKE', '%' . $searchTerm . '%')
                ->orWhere('lead_owner', 'LIKE', '%' . $searchTerm . '%')
                ->orWhere('lead_source', 'LIKE', '%' . $searchTerm . '%')
                ->orWhere('company', 'LIKE', '%' . $searchTerm . '%')
                ->orWhere('industry', 'LIKE', '%' . $searchTerm . '%');
        });

        return $query->paginate(config('constants.ROW_PER_PAGE'));
    }

    public function deleteLead_backup($id)
    {
        $lead = Lead::findOrFail($id);
        $lead->delete();
    }

    public function deleteLead($id)
    {

        $lead = Lead::findOrFail($id);
        $lead->delete();
        //dynamic fields tables for the lead
        $fields = LeadFormDetail::where('form_id', $lead->form_id)->get();
        //delet data in thedynamic tables
        foreach ($fields as $field) {
            $tableName = $field->table_name;
            //delete on table name and lead_id
            DB::table($tableName)->where('lead_id', $lead->id)->delete();
        }
    }

    public function deleteTableRecord($tableName, $id, $leadId)
    {   // fetch fields for the table
        $fields = LeadFormDetail::where('table_name', $tableName)->get();
        $record = DB::table($tableName)->where('id', $id)->first();
        if (!$record) {
            throw new \Exception('Record not found.');
        }
        //loop through each field to check for files
        foreach ($fields as $field) {
            $columnName = $field->field_name;
            if ($field->field_value === 'file' && !empty($record->$columnName)) {
                $filePath = getcwd() . '/uploads/files/' . $record->$columnName;

                if (file_exists($filePath)) {
                    @unlink($filePath); //remove the file from the server
                }
            }
        }
        DB::table($tableName)->where('id', $id)->delete();
    }

    public function search_on_url($request)
    {
        $searchTerm = trim($request);

        $query = Lead::query();
        $query->where(function ($q) use ($searchTerm) {
            $q->where('title', 'LIKE', '%' . $searchTerm . '%')
                ->orWhere('first_name', 'LIKE', '%' . $searchTerm . '%')
                ->orWhere('last_name', 'LIKE', '%' . $searchTerm . '%')
                ->orWhere('email', 'LIKE', '%' . $searchTerm . '%')
                ->orWhere('phone', 'LIKE', '%' . $searchTerm . '%')
                ->orWhere('gender', 'LIKE', '%' . $searchTerm . '%')
                ->orWhere('dob', 'LIKE', '%' . $searchTerm . '%')
                ->orWhere('age', 'LIKE', '%' . $searchTerm . '%')
                ->orWhere('lead_rating', 'LIKE', '%' . $searchTerm . '%')
                ->orWhere('lead_owner', 'LIKE', '%' . $searchTerm . '%')
                ->orWhere('lead_source', 'LIKE', '%' . $searchTerm . '%')
                ->orWhere('company', 'LIKE', '%' . $searchTerm . '%')
                ->orWhere('industry', 'LIKE', '%' . $searchTerm . '%');
        });

        return $query->paginate(config('constants.ROW_PER_PAGE'));
    }

}
