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
        Schema::create('inventory_transfers', function (Blueprint $table) {
            $table->id();

            $table->foreignId('inventory_id')->constrained('inventories')->onDelete('cascade');
            $table->foreignId('asset_id')->nullable()->constrained('assets')->onDelete('cascade');
            $table->foreignId('from_outlet_id')->constrained('outlets')->onDelete('cascade');
            $table->foreignId('to_outlet_id')->constrained('outlets')->onDelete('cascade');
            $table->unsignedInteger('quantity')->default(1);
            $table->date('transfer_date')->nullable();
            $table->string('status')->default('Completed');
            $table->text('description')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();

            $table->index('transfer_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventory_transfers');
    }
};
