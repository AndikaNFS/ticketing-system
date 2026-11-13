<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PicSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('pics')->insert([
             [
                'name' => 'Bambang',
                'no_telp' => '082384123',
            ],
            [
                'name' => 'Sandi',
                'no_telp' => '0810234123',
            ],
        ]);
    }
}
