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
            $table->foreignId('outlet_id')->constrained()->onDelete('cascade');
            $table->enum('status', ['Open', 'InProgress', 'Done', 'Cancel'])->default('Open');
            $table->string('it_name')->nullable();
            $table->dateTime('date_finish')->nullable();
            $table->dateTime('start_date')->nullable();
            $table->string('lama_pengerjaan')->nullable();
            $table->string('user')->nullable();
            $table->string('description')->nullable();
            // $table->dropColumn('user');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tickets', function (Blueprint $table) {
            $table->dropColumn('user'); // Hapus kolom user jika rollback
            // $table->string('user')->nullable();
        });
    }
};
