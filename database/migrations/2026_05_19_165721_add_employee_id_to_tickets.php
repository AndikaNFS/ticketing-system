<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('tickets', function (Blueprint $table) {
            $table->unsignedBigInteger('employee_id')->nullable()->after('status');
             $table->foreign('employee_id')->references('id')->on('employees')->onDelete('set null');
            $table->unsignedBigInteger('edited_by')->nullable()->after('employee_id');
            $table->foreign('edited_by')->references('id')->on('users')->onDelete('set null');  
            $table->unsignedBigInteger('outlet_id')->nullable()->after('employee_id');
            $table->foreign('outlet_id')->references('id')->on('outlets')->onDelete('set null');    
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tickets', function (Blueprint $table) {
            //
        });
    }
};
