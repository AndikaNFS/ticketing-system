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
            ['name' => 'Irfan', 'position' => 'Staff Maintenance'],
            ['name' => 'Sandi', 'position' => 'Staff Maintenance'],
            ['name' => 'Handoko', 'position' => 'Staff Maintenance'],
            ['name' => 'Reza', 'position' => 'Staff Maintenance'],
        ]);
    }
}
