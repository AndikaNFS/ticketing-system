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
        Schema::create('inventory_repairs', function (Blueprint $table) {
            $table->id();

            $table->foreignId('inventory_id')->constrained('inventories')->onDelete('cascade');
            $table->foreignId('asset_id')->nullable()->constrained('assets')->onDelete('cascade');
            $table->foreignId('outlet_id')->constrained('outlets')->onDelete('cascade');
            $table->dateTime('repair_date')->nullable();
            $table->string('status')->default('Repair');
            $table->text('description')->nullable();
            $table->decimal('cost', 15, 2)->default(0.00)->nullable();
            $table->dateTime('completed_at')->nullable();
            $table->timestamps();

            $table->index('repair_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventory_repairs');
    }
};
