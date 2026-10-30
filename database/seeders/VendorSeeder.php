<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class VendorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('vendors')->insert([
            [
                'name' => 'TOTO',
                'alamat' => 'Jaksel',
                'no_telp' => '082384123',
            ],
            [
                'name' => 'WIKA',
                'alamat' => 'Bogor',
                'no_telp' => '0810234123',
            ],
        ]);
    }
}
