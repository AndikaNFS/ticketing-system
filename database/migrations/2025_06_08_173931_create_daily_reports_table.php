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
        Schema::create('daily_reports', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->constrained()->onDelete('cascade');
            // $table->foreignId('outlet_id')->constrained()->onDelete('cascade');
            $table->date('date');
            $table->text('prev_work')->nullable();
            $table->text('today_work')->nullable();
            $table->text('notes')->nullable();
            $table->enum('status', ['selesai','belum','libur'])->default('belum');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('daily_reports');
    }
};
