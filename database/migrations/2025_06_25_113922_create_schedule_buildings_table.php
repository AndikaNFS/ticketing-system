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
        Schema::create('schedule_buildings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employeebuild_id')->constrained('employeebuilds')->onDelete('cascade');
            $table->date('date')->index();
            $table->string('status')->default('Work');
            // $table->enum('status', ['Work', 'Off', 'Holiday']); // Off, Work, Holiday
            $table->string('remarks')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('schedule_buildings');
    }
};
