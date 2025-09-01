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
        Schema::create('visit_buildings', function (Blueprint $table) {
            $table->id();
            $table->string('employeebuild');
            $table->dateTime('tanggal_visit');
            $table->foreignId('outlet_id')->constrained()->onDelete('cascade');
            $table->foreignId('building_id')->nullable()->constrained()->onDelete('cascade');
            $table->enum('status', ['Cancelled','Finished', 'Reschedule', 'InProgress','Open'])->default('Open');
            $table->string('jobdesk')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('visit_buildings');
    }
};
