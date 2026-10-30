<?php

use App\Models\Employee;
use App\Models\Ticket;
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
        // Schema::table('tickets', function (Blueprint $table) {
        //     //
        // });
        
        $tickets = Ticket::all();

        foreach ($tickets as $ticket) {
            $emp = Employee::where('name', $ticket->it_name)->first();

            if ($emp) {
                $ticket->employee_id = $emp->id;
                $ticket->save();
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tickets', function (Blueprint $table) {
            //
        });
    }
};
