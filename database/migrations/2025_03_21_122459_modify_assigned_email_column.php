<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up()
    {
        Schema::table('tasks', function (Blueprint $table) {
            // Check if the foreign key exists before dropping it
            $foreignKeys = DB::select("SELECT CONSTRAINT_NAME FROM information_schema.KEY_COLUMN_USAGE 
                WHERE TABLE_NAME = 'tasks' AND COLUMN_NAME = 'assigned_email' AND CONSTRAINT_SCHEMA = DATABASE()");
            
            if (!empty($foreignKeys)) {
                $table->dropForeign(['assigned_email']);
            }

            // Modify assigned_email column
            $table->string('assigned_email')->nullable()->change();

            // Re-add foreign key constraint
            $table->foreign('assigned_email')->references('email')->on('users')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('tasks', function (Blueprint $table) {
            // Check if the foreign key exists before dropping it
            $foreignKeys = DB::select("SELECT CONSTRAINT_NAME FROM information_schema.KEY_COLUMN_USAGE 
                WHERE TABLE_NAME = 'tasks' AND COLUMN_NAME = 'assigned_email' AND CONSTRAINT_SCHEMA = DATABASE()");
            
            if (!empty($foreignKeys)) {
                $table->dropForeign(['assigned_email']);
            }

            // Revert assigned_email column back to string
            $table->string('assigned_email')->nullable()->change();

            // Re-add the foreign key constraint
            $table->foreign('assigned_email')->references('email')->on('users')->onDelete('cascade');
        });
    }
};
