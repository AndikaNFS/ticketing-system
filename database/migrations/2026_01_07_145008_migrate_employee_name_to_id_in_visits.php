<?php

use App\Models\Employee;
use App\Models\Visit;
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
        // Schema::table('visits', function (Blueprint $table) {
        //     //
        // });
        $visits = Visit::all();

        foreach ($visits as $visit) {
            $emp = Employee::where('name', $visit->pic)->first();

            if ($emp) {
                $visit->employee_id = $emp->id;
                $visit->save();
            }
        }

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('visits', function (Blueprint $table) {
            //
        });
    }
};
