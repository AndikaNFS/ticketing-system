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
        Schema::table('outlets', function (Blueprint $table) {
            //
            if (!Schema::hasColumn('outlets', 'employee_id')) {
                $table->unsignedBigInteger('employee_id')->nullable()->after('area');
                $table->foreign('employee_id')->references('id')->on('outlets')->onDelete('cascade');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('outlets', function (Blueprint $table) {
            //
            $table->dropForeign(['employee_id']);
            $table->dropColumn('employee_id');
        });
    }
};
