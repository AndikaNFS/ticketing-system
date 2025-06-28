<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('employees')->insert([
            // ['name' => 'Santo', 'position' => 'Leader IT'],
            // ['name' => 'Andika', 'position' => 'IT Support'],
            // ['name' => 'Asep', 'position' => 'IT Support'],
            // ['name' => 'Kodam', 'position' => 'IT Support'],
            ['name' => 'All', 'position' => 'IT Support'],
        ]);

    }
}
