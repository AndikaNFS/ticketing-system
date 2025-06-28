<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EmployeeBuildingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        DB::table('employeebuilds')->insert([
            ['name' => 'Bambang', 'position' => 'Leader Maintenance'],
            ['name' => 'Irfan', 'position' => 'Maintenance'],
            ['name' => 'Sandi', 'position' => 'Maintenance'],
            ['name' => 'Handoko', 'position' => 'Maintenance'],
            ['name' => 'Reza', 'position' => 'Maintenance'],
        ]);
    }
}
