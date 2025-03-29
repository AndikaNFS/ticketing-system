<?php

namespace Database\Seeders;

use App\Models\Ticket;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TicketSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ticket::create([
        //     'ticketing' => 'R001',
        //     'problem' => 'Printer Error',
        //     'outlet' => 'Lotte',
        //     'status' => 'Open',
        //     'it_name' => null,
        //     'date_finish' => null,
        //     'lama_pengerjaan' => null,
        // ]);

        User::create([
            'name' => 'Admin IT',
            'email' => 'itrrchocolate@gmail.com',
            'password' => bcrypt('*mhb2020'),
        ]);
    }
}
