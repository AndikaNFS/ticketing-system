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
        // Schema::table('buildings', function (Blueprint $table) {
            
        // });

        $buildings = \App\Models\Building::all();
        foreach ($buildings as $building) {
            if ($building->pic_id) {
                $building->employeebuild_id = $building->pic_id;
                $building->save();
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('buildings', function (Blueprint $table) {
            //
        });
    }
};
