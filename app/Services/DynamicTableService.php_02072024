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
            ->paginate(config('constants.ROW_PER_PAGE'));
    }

    public function createTable($tableName, $formId, $fields)
    {
        // the table already exists show this message
        if (Schema::hasTable($tableName)) {
            return 'Table already exists.';
        }

        // Create the table if it doesn't exist
        Schema::create($tableName, function (Blueprint $table) use ($fields) {
            $table->id();
            $table->unsignedBigInteger('lead_id');
            $table->char('form_id', 10)->nullable(false);
            
            foreach ($fields as $field) {
                $type = $field['type'];
                $name = $field['name'];
                $length = $field['character_length'] ?? null;

                if ($type === 'varchar' && $length) {
                    $column = $table->string($name, $length)->nullable();
                } elseif ($type === 'int') {
                    $column = $table->integer($name)->nullable();
                } elseif ($type === 'char' && $length) {
                    $column = $table->char($name, $length)->nullable();
                } elseif ($type === 'date') {
                    $column = $table->date($name)->nullable();
                } elseif ($type === 'text') {
                    $column = $table->text($name)->nullable();
                } elseif ($type === 'boolean') {
                    $column = $table->boolean($name)->nullable();
                } else {
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



    public function updateTable($tableName, $formId, $fields, $id)
    {
        $tableDetails = LeadFormDetail::where('table_name', $id)->get();
        if (!$tableDetails) {
            return 'Table not found.';
        }

        $existingColumns = Schema::getColumnListing($tableName);

        Schema::table($tableName, function (Blueprint $table) use ($fields, $existingColumns, $tableName) {
            foreach ($fields as $field) {
                $type = $field['type'];
                $name = $field['name'];
                $length = $field['character_length'] ?? null;

                if (!in_array($name, $existingColumns)) {
                    $this->addColumn($table, $field);
                } else {
                    $this->modifyColumn($table, $field);
                }

                $this->updateConstraints($table, $field, $tableName);
            }
        });

        $data = $this->prepareLeadFormDetailsData($fields, $formId, $tableName);
        $this->updateLeadFormDetails($tableName, $data);

        return 'Table columns updated successfully.';
    }

    private function addColumn(Blueprint $table, $field)
    {
        $type = $field['type'];
        $name = $field['name'];
        $length = $field['character_length'] ?? null;

        $column = null;

        switch ($type) {
            case 'varchar':
                $column = $table->string($name, $length);
                break;
            case 'int':
                $column = $table->integer($name);
                break;
            case 'char':
                $column = $table->char($name, $length);
                break;
            case 'date':
                $column = $table->date($name);
                break;
            case 'text':
                $column = $table->text($name);
                break;
            case 'boolean':
                $column = $table->boolean($name);
                break;
            default:
                throw new \Exception("Unsupported column type: {$type}");
        }

        if ($column) {
            if (!isset($field['is_null']) || !$field['is_null']) {
                $column->nullable(false);
            } else {
                $column->nullable();
            }
        }
    }

    private function modifyColumn(Blueprint $table, $field)
    {
        $type = $field['type'];
        $name = $field['name'];
        $length = $field['character_length'] ?? null;

        $column = null;

        switch ($type) {
            case 'varchar':
                $column = $table->string($name, $length);
                break;
            case 'int':
                $column = $table->integer($name);
                break;
            case 'char':
                $column = $table->char($name, $length);
                break;
            case 'date':
                $column = $table->date($name);
                break;
            case 'text':
                $column = $table->text($name);
                break;
            case 'boolean':
                $column = $table->boolean($name);
                break;
            default:
                throw new \Exception("Unsupported column type: {$type}");
        }

        if ($column) {
            if (!isset($field['is_null']) || !$field['is_null']) {
                $column->nullable(false)->change();
            } else {
                $column->nullable()->change();
            }
        }
    }

    private function updateConstraints(Blueprint $table, $field, $tableName)
    {
        $name = $field['name'];
        $indexName = $tableName . '_' . $name . '_index';
        $uniqueName = $tableName . '_' . $name . '_unique';

        // Check if index should exist
        if (isset($field['is_index']) && $field['is_index']) {
            // Add index if it doesn't exist
            if (!$this->hasIndex($tableName, $indexName)) {
                $table->index($name);
            }
        } else {
            // Drop index if it exists
            if ($this->hasIndex($tableName, $indexName)) {
                $table->dropIndex($indexName);
            }
        }

        // Check if unique constraint should exist
        if (isset($field['is_unique']) && $field['is_unique']) {
            // Add unique constraint if it doesn't exist
            if (!$this->hasIndex($tableName, $uniqueName)) {
                $table->unique($name);
            }
        } else {
            // Drop unique constraint if it exists
            if ($this->hasIndex($tableName, $uniqueName)) {
                $table->dropUnique($uniqueName);
            }
        }
    }

    private function hasIndex($tableName, $indexName)
    {
        return Schema::hasTable($tableName) && Schema::hasIndex($tableName, $indexName);
    }

    private function prepareLeadFormDetailsData($fields, $formId, $tableName)
    {
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

