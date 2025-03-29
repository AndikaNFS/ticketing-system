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
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->string('ticketing');
            $table->string('problem');
            $table->string('outlet');
            $table->enum('status', ['Open', 'OnProgress', 'Done', 'Cancel'])->default('Open');
            $table->string('it_name')->nullable();
            $table->string('date_finish')->nullable();
            $table->string('lama_pengerjaan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};
