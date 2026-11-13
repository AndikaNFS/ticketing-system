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
        Schema::create('asset_repair_images', function (Blueprint $table) {
            $table->id();
            $table->foreignId('inventory_repair_id')->constrained('inventory_repairs')->cascadeOnDelete();
            $table->string('image_path');
            $table->string('image_type', 50)->default('damage');

            $table->timestamps();
            $table->index('image_type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('asset_repair_images');
    }
};
