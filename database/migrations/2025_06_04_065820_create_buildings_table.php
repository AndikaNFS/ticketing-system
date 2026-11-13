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
        Schema::create('buildings', function (Blueprint $table) {
            $table->id();
            $table->string('ticketing');
            $table->string('user');
            $table->string('problem');
            $table->string('description')->nullable();
            $table->foreignId('vendor_id')->nullable();
            $table->foreignId('outlet_id');
            $table->foreignId('pic_id')->nullable();
            $table->dateTime('start_date')->nullable();
            $table->dateTime('finish_date')->nullable();
            $table->string('work_duration')->nullable();
            $table->enum('status', ['Open', 'InProgress', 'Done', 'Cancel'])->default('Open');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('buildings');
    }
};
