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
        Schema::create('inventories', function (Blueprint $table) {
            $table->id();

            $table->foreignId('category_id')->constrained('categories')->onDelete('cascade');
            $table->foreignId('outlet_id')->constrained('outlets')->onDelete('cascade');
            $table->foreignId('sources_outlet_id')->nullable()->constrained('outlets')->onDelete('cascade');
            $table->string('device');
            $table->string('brand')->nullable();
            $table->string('placement')->nullable();
            $table->boolean('is_tracked')->default(false);
            $table->unsignedBigInteger('quantity')->default(0);
            $table->date('entry_date')->nullable();
            $table->text('description')->nullable();
            $table->timestamps();

            $table->index('device');
            $table->index('brand');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventories');
    }
};
