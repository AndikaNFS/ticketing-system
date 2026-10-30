<?php

namespace Database\Seeders;

use App\Models\Ticket;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class TicketSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 0; $i < 20; $i++) {
        Ticket::create([
            'ticketing' => 'R001'. strtoupper(Str::random(6)),
            'problem' => 'Printer Error' . ($i + 1),
            'outlet' => 'Lotte' . rand(1, 5),
            'status' => collect(['Open', 'InProgress', 'Done', 'Cancel'])->random(),
            'it_name' => 'IT-' . rand(1, 5),
            'date_finish' => now()->addDays(rand(1, 7)),
            'lama_pengerjaan' => null,
        ]);
    }

        // User::create(
        //     [
        //     'name' => 'Admin IT',
        //     'email' => 'itrrchocolate@gmail.com',
        //     'password' => bcrypt('*mhb2020'),
        //     ]);
        
            
    }
}
