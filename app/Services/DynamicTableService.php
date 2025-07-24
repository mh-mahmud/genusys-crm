<?php

namespace App\Services;

use App\Models\Promotion;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use App\Models\LeadFormDetail;

class DynamicTableService
{
    public function getAllDynamicTables()
    {
        return LeadFormDetail::select('table_name', 'form_id')
            ->with('leadsForm:form_id,form_name')
            ->groupBy('table_name', 'form_id')
            ->orderBy('table_name')
            ->paginate(config('constants.ROW_PER_PAGE'));
    }

    public function createTable($tableName, $formId, $fields, $viewType, $formSize)
    {
        // table already exists show this message
        if (Schema::hasTable($tableName)) {
            return 'Table already exists.';
        }

        // create the new table if it doesn't exist
        Schema::create($tableName, function (Blueprint $table) use ($fields) {
            $table->id();
            $table->unsignedBigInteger('lead_id');
            $table->char('form_id', 10)->nullable(false);
            $table->string('created_by', 191)->nullable();
            
            foreach ($fields as $field) {
                $type = $field['type'];
                $name = $field['name'];
                $length = $field['character_length'] ?? null;

                if ($type === 'varchar') {
                    if (is_numeric($length) && $length > 255) {
                        throw new \Exception("The character length for the String Field Value {$name} cannot exceed 255");
                    }
                    $column = $table->string($name, $length)->nullable();
                } elseif ($type === 'int') {
                    $column = $table->integer($name)->nullable();
                } elseif ($type === 'char') {
                    if (is_numeric($length) && $length > 255) {
                        throw new \Exception("The character length for the  Character Field Value {$name}  cannot exceed 255.");
                    }
                    $column = $table->char($name, $length)->nullable();
                } elseif ($type === 'date') {
                    $column = $table->date($name)->nullable();
                } elseif ($type === 'text') {
                    $column = $table->text($name)->nullable();
                } elseif ($type === 'boolean') {
                    $column = $table->boolean($name)->nullable();
                } elseif ($type === 'file') {
                    $column = $table->string($name)->nullable();
                } elseif ($type === 'dropdown') {
                    //an array for the enum
                    if (is_string($length)) {
                        $length = explode(',', $length); //string to an array
                    }
                    $column = $table->enum($name, (array) $length)->nullable();
                }
                 else {
                    $column = $table->$type($name)->nullable();
                }

                if (isset($field['is_index']) && $field['is_index']) {
                    $table->index($name);
                }
                if (isset($field['is_unique']) && $field['is_unique']) {
                    $table->unique($name);
                }

                if (!isset($field['is_null']) || !$field['is_null']) {
                    $column->nullable(false);
                }
            }
            $table->timestamps();
        });

        //insert data in table
        $data = [];
        foreach ($fields as $field) {
            $data[] = [
                'form_id' => $formId,
                'field_name' => $field['name'],
                'field_value' => $field['type'],
                'table_name' => $tableName,
                'character_length' => $field['character_length'] ?? null,
                'is_index' => $field['is_index'] ?? 0,
                'is_null' => $field['is_null'] ?? 0,
                'is_unique' => $field['is_unique'] ?? 0,
                'view_type' => $viewType,
                'form_size' => $formSize,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        
        DB::table('lead_form_details')->insert($data);

        return 'Data inserted successfully.';
    }


    public function getDynamicTableDetails($id)
    {
        return LeadFormDetail::findOrFail($id);
    }

    public function getDetailsByTableName($tableName)
    {
        return LeadFormDetail::where('table_name', $tableName)->get();
    }

    public function updateTable_backup($tableName, $formId, $fields, $id)
    {
        $tableDetails = LeadFormDetail::where('table_name', $id)->get();
        if (!$tableDetails) {
            return 'Table not found.';
        }

        Schema::table($tableName, function (Blueprint $table) use ($fields) {
            foreach ($fields as $field) {
                $type = $field['type'];
                $name = $field['name'];
                $length = $field['character_length'] ?? null;

                if (Schema::hasColumn($table->getTable(), $name)) {
                    continue;
                }

                if ($type === 'varchar' && $length) {
                    $table->string($name, $length)->nullable();
                } elseif ($type === 'int') {
                    $table->integer($name)->nullable();
                } elseif ($type === 'char' && $length) {
                    $table->char($name, $length)->nullable();
                } elseif ($type === 'date') {
                    $table->date($name)->nullable();
                } elseif ($type === 'text') {
                    $table->text($name)->nullable();
                } elseif ($type === 'boolean') {
                    $table->boolean($name)->nullable();
                } else {
                    $table->$type($name)->nullable();
                }

                if (isset($field['is_index']) && $field['is_index']) {
                    $table->index($name);
                }
                if (isset($field['is_unique']) && $field['is_unique']) {
                    $table->unique($name);
                }

                //if (!isset($field['is_null']) || !$field['is_null']) {
                   // $table->nullable(false);
                //}
            }
        });

        //process insert data in table
        $data = [];
        foreach ($fields as $field) {
            $data[] = [
                'form_id' => $formId,
                'field_name' => $field['name'],
                'field_value' => $field['type'],
                'table_name' => $tableName,
                'character_length' => $field['character_length'] ?? null,
                'is_index' => $field['is_index'] ?? 0,
                'is_null' => $field['is_null'] ?? 0,
                'is_unique' => $field['is_unique'] ?? 0,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        // Insert data into the lead_form_details table
        DB::table('lead_form_details')->where('table_name', $tableName)->delete();
        DB::table('lead_form_details')->insert($data);

        return 'Data updated successfully.';
    }


    public function updateTable_update($tableName, $formId, $fields, $id)
{
    // Check if the table details exist based on the $id
    $tableDetails = LeadFormDetail::where('table_name', $id)->get();
    if (!$tableDetails) {
        return 'Table not found.';
    }

    // Get the current column names of the table
    $existingColumns = Schema::getColumnListing($tableName);

    // Determine the columns to add or modify
    $columnsToAdd = [];
    $columnsToModify = [];
    foreach ($fields as $field) {
        $type = $field['type'];
        $name = $field['name'];
        $length = $field['character_length'] ?? null;

        if (!in_array($name, $existingColumns)) {
            // Column does not exist, add it
            $columnsToAdd[] = $field;
        } else {
            // Column exists, check if modification is needed
            $currentType = Schema::getColumnType($tableName, $name);
            if ($currentType !== $type) {
                $columnsToModify[] = $field;
            }
        }
    }

    // Add columns that do not exist
    foreach ($columnsToAdd as $field) {
        $type = $field['type'];
        $name = $field['name'];
        $length = $field['character_length'] ?? null;

        if ($type === 'varchar' && $length) {
            Schema::table($tableName, function (Blueprint $table) use ($name, $length) {
                $table->string($name, $length)->nullable();
            });
        } elseif ($type === 'int' && $length) {
            Schema::table($tableName, function (Blueprint $table) use ($name) {
                $table->integer($name)->nullable();
            });
        } elseif ($type === 'char' && $length) {
            Schema::table($tableName, function (Blueprint $table) use ($name, $length) {
                $table->char($name, $length)->nullable();
            });
        } elseif ($type === 'date') {
            Schema::table($tableName, function (Blueprint $table) use ($name) {
                $table->date($name)->nullable();
            });
        } elseif ($type === 'text') {
            Schema::table($tableName, function (Blueprint $table) use ($name) {
                $table->text($name)->nullable();
            });
        } elseif ($type === 'boolean') {
            Schema::table($tableName, function (Blueprint $table) use ($name) {
                $table->boolean($name)->nullable();
            });
        } else {
            Schema::table($tableName, function (Blueprint $table) use ($type, $name) {
                $table->$type($name)->nullable();
            });
        }
        
        // Add index if specified
        if (isset($field['is_index']) && $field['is_index']) {
            Schema::table($tableName, function (Blueprint $table) use ($name) {
                $table->index($name);
            });
        }

        // Add unique constraint if specified
        if (isset($field['is_unique']) && $field['is_unique']) {
            Schema::table($tableName, function (Blueprint $table) use ($name) {
                $table->unique($name);
            });
        }

        // Set column as not nullable if specified
        if (!isset($field['is_null']) || !$field['is_null']) {
            Schema::table($tableName, function (Blueprint $table) use ($name) {
                $table->string($name)->nullable(false)->change();
            });
        }
    }

    // Modify columns with different types
    foreach ($columnsToModify as $field) {
        $type = $field['type'];
        $name = $field['name'];

        // Drop the existing column
        Schema::table($tableName, function (Blueprint $table) use ($name) {
            $table->dropColumn($name);
        });

        // Add the column with the new type
        if ($type === 'varchar') {
            Schema::table($tableName, function (Blueprint $table) use ($field) {
                $table->string($field['name'], $field['character_length'] ?? null)->nullable();
            });
        } elseif ($type === 'int') {
            Schema::table($tableName, function (Blueprint $table) use ($field) {
                $table->integer($field['name'])->nullable();
            });
        } elseif ($type === 'char') {
            Schema::table($tableName, function (Blueprint $table) use ($field) {
                $table->char($field['name'], $field['character_length'] ?? null)->nullable();
            });
        } elseif ($type === 'date') {
            Schema::table($tableName, function (Blueprint $table) use ($field) {
                $table->date($field['name'])->nullable();
            });
        } elseif ($type === 'text') {
            Schema::table($tableName, function (Blueprint $table) use ($field) {
                $table->text($field['name'])->nullable();
            });
        } elseif ($type === 'boolean') {
            Schema::table($tableName, function (Blueprint $table) use ($field) {
                $table->boolean($field['name'])->nullable();
            });
        } else {
            Schema::table($tableName, function (Blueprint $table) use ($type, $field) {
                $table->$type($field['name'])->nullable();
            });
        }
        
        // Add index if specified
        if (isset($field['is_index']) && $field['is_index']) {
            Schema::table($tableName, function (Blueprint $table) use ($name) {
                $table->index($name);
            });
        }

        // Add unique constraint if specified
        if (isset($field['is_unique']) && $field['is_unique']) {
            Schema::table($tableName, function (Blueprint $table) use ($name) {
                $table->unique($name);
            });
        }

        // Set column as not nullable if specified
        if (!isset($field['is_null']) || !$field['is_null']) {
            Schema::table($tableName, function (Blueprint $table) use ($name) {
                $table->string($name)->nullable(false)->change();
            });
        }else{
            Schema::table($tableName, function (Blueprint $table) use ($name) {
                $table->string($name)->nullable(false)->change();
            });
        }
    }

    // Process insert data in the lead form details table
    $data = [];
    foreach ($fields as $field) {
        $data[] = [
            'form_id' => $formId,
            'field_name' => $field['name'],
            'field_value' => $field['type'],
            'table_name' => $tableName,
            'character_length' => $field['character_length'] ?? null,
            'is_index' => $field['is_index'] ?? 0,
            'is_null' => $field['is_null'] ?? 0,
            'is_unique' => $field['is_unique'] ?? 0,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }

    // Delete existing records for the table in the lead form details table
    DB::table('lead_form_details')->where('table_name', $tableName)->delete();
    // Insert updated data into the lead form details table
    DB::table('lead_form_details')->insert($data);

    return 'Table columns updated successfully.';
}



    public function updateTable($tableName, $formId, $fields, $id,$viewType,$formSize)
    {
        // chk table details exist based on the $id
        $tableDetails = LeadFormDetail::where('table_name', $id)->first();
        if (!$tableDetails) {
            return 'Table not found.';
        }

        // get the exist column names of the table
        $existingColumns = Schema::getColumnListing($tableName);
        //dd($existingColumns);die();

        // collect columns to be deleted
       // $columnsToDelete = array_diff($existingColumns, array_column($fields, 'name'));
       $columnsToDelete = array_diff($existingColumns, array_merge(array_column($fields, 'name'), ['id', 'lead_id', 'form_id','created_by', 'created_at', 'updated_at']));

        Schema::table($tableName, function (Blueprint $table) use ($fields, $columnsToDelete, $existingColumns) {
            // Ensure required columns exist
            if (!in_array('id', $existingColumns)) {
                $table->id()->first();
            }
            if (!in_array('lead_id', $existingColumns)) {
                $table->unsignedBigInteger('lead_id')->after('id');
            }
            if (!in_array('form_id', $existingColumns)) {
                $table->char('form_id', 10)->nullable(false)->after('lead_id');
            }
            if (!in_array('created_by', $existingColumns)) {
                $table->string('created_by', 191)->nullable()->after('form_id');
                
            }
            if (!in_array('created_at', $existingColumns)) {
                $table->timestamp('created_at')->nullable()->after('created_by');
            }
            if (!in_array('updated_at', $existingColumns)) {
                $table->timestamp('updated_at')->nullable()->after('created_at');
            }
            // Delete columns that are not in the $fields array
            foreach ($columnsToDelete as $column) {
                $table->dropColumn($column);
            }

            // Add or modify columns based on the $fields array
            foreach ($fields as $field) {
                $name = $field['name'];

                if (!in_array($name, $existingColumns)) {
                    // column does not exist, add
                    $this->addColumn($table, $field);
                } else {
                    //column exists, modify it
                    $this->modifyColumn($table, $field, $name);// Pass existing column name
                }

                // update index and unique constraints
                $this->updateConstraints($table, $field, $table->getTable());
            }
        });

        // prepare data for lead_form_details table custom function
        $data = $this->prepareLeadFormDetailsData($fields, $formId, $tableName,$viewType,$formSize);

        // update lead_form_details table
        $this->updateLeadFormDetails($tableName, $data);

        return 'Table columns updated successfully.';
    }

    private function addColumn(Blueprint $table, $field)
    {
        $type = $field['type'];
        $name = $field['name'];
        $length = $field['character_length'] ?? null;

        switch ($type) {
            case 'varchar':
                if (is_numeric($length) && $length > 255) {
                    throw new \Exception("The character length for the String Field Value {$name} cannot exceed 255");
                }
                $column = $table->string($name, $length)->nullable();
                break;
            case 'int':
                $column = $table->integer($name)->nullable();
                break;
            case 'char':
                if (is_numeric($length) && $length > 255) {
                    throw new \Exception("The character length for the  Character Field Value {$name}  cannot exceed 255.");
                }
                $column = $table->char($name, $length)->nullable();
                break;
            case 'date':
                $column = $table->date($name)->nullable();
                break;
            case 'text':
                $column = $table->text($name)->nullable();
                break;
            case 'boolean':
                $column = $table->boolean($name)->nullable();
                break;
            case 'file':
                $column = $table->string($name)->nullable();
                break;
            case 'dropdown':
                if (is_string($length)) {
                    $length = explode(',', $length); // Convert comma-separated string to an array
                }
                $column = $table->enum($name, (array) $length)->nullable();
                break;
            default:
                throw new \Exception("Unsupported column type: {$type}");
        }

        // set column as not nullable if specified
        if (!isset($field['is_null']) || !$field['is_null']) {
            $column->nullable(false);
        }
    }

    private function modifyColumn(Blueprint $table, $field, $existingColumnName)
    {
        $type = $field['type'];
        $length = $field['character_length'] ?? null;

        switch ($type) {
            case 'varchar':
                if (is_numeric($length) && $length > 255) {
                    throw new \Exception("The character length for the String Field Value {$existingColumnName} cannot exceed 255");
                }
                $column = $table->string($existingColumnName, $length)->nullable()->change();
                break;
            case 'int':
                $column = $table->integer($existingColumnName)->nullable()->change();
                break;
            case 'char':
                if (is_numeric($length) && $length > 255) {
                    throw new \Exception("The character length for the  Character Field Value {$existingColumnName}  cannot exceed 255.");
                }
                $column = $table->char($existingColumnName, $length)->nullable()->change();
                break;
            case 'date':
                $column = $table->date($existingColumnName)->nullable()->change();
                break;
            case 'text':
                $column = $table->text($existingColumnName)->nullable()->change();
                break;
            case 'boolean':
                $column = $table->boolean($existingColumnName)->nullable()->change();
                break;
            case 'file':
                $column = $table->string($existingColumnName)->nullable()->change();
                break;
            case 'dropdown':
                //$column = $table->string($existingColumnName)->nullable()->change();
                if (is_string($length)) {
                    $length = explode(',', $length); // Convert comma-separated string to an array
                }
                $column = $table->enum($existingColumnName, (array) $length)->nullable()->change();
                break;
            default:
                throw new \Exception("Unsupported column type: {$type}");
        }

        // set column as not nullable if specified
        if (!isset($field['is_null']) || !$field['is_null']) {
            $column->nullable(false)->change();
        }
    }


    private function modifyColumn_backup(Blueprint $table, $field, $existingColumnName)
    {
        $newName = $field['name']; // New name for the column
        $type = $field['type'];
        $length = $field['character_length'] ?? null;
        $position = $field['position'] ?? null; // Position (after another column or first)

        // Rename the column if the name has changed
        if ($existingColumnName !== $newName) {
            $table->renameColumn($existingColumnName, $newName);
        }

        // Modify the column type and other attributes
        switch ($type) {
            case 'varchar':
                $column = $table->string($newName, $length)->nullable()->change();
                break;
            case 'int':
                $column = $table->integer($newName)->nullable()->change();
                break;
            case 'char':
                $column = $table->char($newName, $length)->nullable()->change();
                break;
            case 'date':
                $column = $table->date($newName)->nullable()->change();
                break;
            case 'text':
                $column = $table->text($newName)->nullable()->change();
                break;
            case 'boolean':
                $column = $table->boolean($newName)->nullable()->change();
                break;
            case 'file':
                $column = $table->string($newName)->nullable()->change();
                break;
            case 'dropdown':
                if (is_string($length)) {
                    $length = explode(',', $length); // Convert comma-separated string to an array
                }
                $column = $table->enum($newName, (array) $length)->nullable()->change();
                break;
            default:
                throw new \Exception("Unsupported column type: {$type}");
        }

        // Set column as not nullable if specified
        if (!isset($field['is_null']) || !$field['is_null']) {
            $column->nullable(false)->change();
        }

        // Adjust the column position if specified
        if ($position) {
            if ($position === 'first') {
                $column->first();
            } else {
                $column->after($position);
            }
        }
    }


    private function updateConstraints(Blueprint $table, $field, $tableName)
    {
        $name = $field['name'];
        $indexName = $tableName . '_' . $name . '_index';
        $uniqueName = $tableName . '_' . $name . '_unique';

        // chk index exist
        if (isset($field['is_index']) && $field['is_index']) {
            // add index if it doesn't exist
            if (!Schema::hasColumn($table->getTable(), $indexName)) {
                $table->index($name);
            }
        } else {
            // drop index if exists
            if (Schema::hasColumn($table->getTable(), $indexName)) {
                $table->dropIndex($indexName);
            }
        }

        // Check if unique constraint should exist
        if (isset($field['is_unique']) && $field['is_unique']) {
            // Add unique constraint if it doesn't exist
            if (!Schema::hasColumn($table->getTable(), $uniqueName)) {
                $table->unique($name);
            }
        } else {
            // drop unique constraint if exists
            if (Schema::hasColumn($table->getTable(), $uniqueName)) {
                $table->dropUnique($uniqueName);
            }
        }
    }

    private function prepareLeadFormDetailsData($fields, $formId, $tableName,$viewType,$formSize)
    {
        $data = [];
        foreach ($fields as $field) {
            $data[] = [
                'form_id' => $formId,
                'field_name' => $field['name'],
                'field_value' => $field['type'],
                'table_name' => $tableName,
                'view_type' => $viewType,
                'form_size' => $formSize,
                'character_length' => $field['character_length'] ?? null,
                'is_index' => $field['is_index'] ?? 0,
                'is_null' => $field['is_null'] ?? 0,
                'is_unique' => $field['is_unique'] ?? 0,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }
        return $data;
    }

    private function updateLeadFormDetails($tableName, $data)
    {
        DB::table('lead_form_details')->where('table_name', $tableName)->delete();
        DB::table('lead_form_details')->insert($data);
    }

  public function searchDynamicTable($request)
    {
        $searchTerm = trim($request->input('search'));

        $query = LeadFormDetail::select('table_name', 'form_id')
            ->with('leadsForm:form_id,form_name')
            ->groupBy('table_name', 'form_id');

        if ($searchTerm) {
            $query->where(function($q) use ($searchTerm) {
                $q->where('table_name', 'LIKE', '%' . $searchTerm . '%')
                ->orWhereHas('leadsForm', function($q) use ($searchTerm) {
                    $q->where('form_name', 'LIKE', '%' . $searchTerm . '%');
                });
            });
        }

        return $query->paginate(config('constants.ROW_PER_PAGE'));
    }

    public function deleteDynamicTable($id)
    {
        $dynamicTables = LeadFormDetail::where('table_name', $id)->get();
        if ($dynamicTables->isEmpty()) {
            return redirect()->route('dynamic_table.index')->with('error', 'Table not found.');
        }
        $tableName = $id;
        LeadFormDetail::where('table_name', $tableName)->delete();
        Schema::dropIfExists($tableName);
    }

}

