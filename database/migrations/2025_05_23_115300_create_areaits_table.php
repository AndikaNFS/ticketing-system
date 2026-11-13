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
        Schema::create('areaits', function (Blueprint $table) {
            $table->id();
            $table->string('area_id')->nullable();
            // $table->string('location');
            $table->string('it_name')->nullable();
            $table->string('pic')->nullable();
            $table->string('outlet_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('areaits');
    }
};
