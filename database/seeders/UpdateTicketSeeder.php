<?php

namespace Database\Seeders;

use App\Models\Outlet;
use App\Models\Ticket;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UpdateTicketSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (Ticket::all() as $ticket) {
            $outlet = Outlet::where('name', $ticket->outlet)->first();
            if ($outlet) {
                $ticket->outlet_id = $outlet->id;
                $ticket->save();
            }
        }
    }
}
