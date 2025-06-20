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
            //
            if (!Schema::hasColumn('tickets', 'outlet_id')) {
                $table->unsignedBigInteger('outlet_id')->nullable()->after('outlet');
                $table->foreign('outlet_id')->references('id')->on('outlets')->onDelete('cascade');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tickets', function (Blueprint $table) {
            //
            $table->dropForeign(['outlet_id']);
            $table->dropColumn('outlet_id');
        });
    }
};
