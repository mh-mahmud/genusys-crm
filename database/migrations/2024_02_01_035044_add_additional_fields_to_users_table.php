<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        // Step 1: Add the new 'first_name' column
        Schema::table('users', function (Blueprint $table) {
            $table->string('first_name')->after('id');
        });

        // Step 2: Copy data from 'name' to 'first_name' using a separate update statement
        DB::table('users')->update(['first_name' => DB::raw('name')]);

        // Step 3: Drop the old 'name' column
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('name');
        });

        // Step 4: Add other columns
        Schema::table('users', function (Blueprint $table) {
            $table->string('middle_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('user_name')->nullable();
            $table->string('phone', 20)->nullable(); // Set length to 20 characters for 'phone'
            $table->char('gender', 1)->nullable();    // Use CHAR for 'gender' with a length of 1 character
            $table->char('status', 1)->nullable();    // Use CHAR for 'status' with a length of 1 character
            $table->text('address')->nullable();      // Use TEXT for 'address'
        });
    }

    public function down()
    {
        // Revert the migration steps in reverse order
        Schema::table('users', function (Blueprint $table) {
            // Step 1: Add the 'name' column back
            $table->string('name')->after('id');
        });

        // Step 2: Copy data from 'first_name' to 'name' using a separate update statement
        DB::table('users')->update(['name' => DB::raw('first_name')]);

        // Step 3: Drop the new 'first_name' column
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('first_name');
        });

        // Step 4: Drop other added columns
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'middle_name',
                'last_name',
                'user_name',
                'phone',
                'gender',
                'status',
                'address',
            ]);
        });
    }
};
