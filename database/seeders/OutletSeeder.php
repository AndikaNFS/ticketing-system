<?php

namespace Database\Seeders;

use App\Models\Outlet;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OutletSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('outlets')->insert([     
            [
                'name' => 'Cikande (Pabrik)',
                'area' => null,
                'location' => null,
            ],
            [
                'name' => 'Kemayoran',
                'area' => null,
                'location' => null,
            ],
            [
                'name' => 'Senopati',
                'area' => null,
                'location' => null,
            ],
            [
                'name' => 'Sudirman',
                'area' => null,
                'location' => null,
            ],
            [
                'name' => 'Plaza Indonesia',
                'area' => null,
                'location' => null,
            ],
            [
                'name' => 'PIK Avenue',
                'area' => null,
                'location' => null,
            ],
            [
                'name' => 'Gandaria City',
                'area' => null,
                'location' => null,
            ],
            [
                'name' => 'Senayan City',
                'area' => null,
                'location' => null,
            ],
            [
                'name' => 'Mall Of Indonesia',
                'area' => null,
                'location' => null,
            ],
            [
                'name' => 'Taman Anggrek',
                'area' => null,
                'location' => null,
            ],
            [
                'name' => 'AEON BSD',
                'area' => null,
                'location' => null,
            ],
            [
                'name' => 'Citos',
                'area' => null,
                'location' => null,
            ],
            [
                'name' => 'Gafoy',
                'area' => null,
                'location' => null,
            ],
            [
                'name' => 'Sumerecon Serpong',
                'area' => null,
                'location' => null,
            ],
            [
                'name' => 'AEON Deltamas',
                'area' => null,
                'location' => null,
            ],
            [
                'name' => 'T3 Domestic',
                'area' => null,
                'location' => null,
            ],
            [
                'name' => 'I Gusti Ngurah Rai',
                'area' => null,
                'location' => null,
            ],
            [
                'name' => 'PURI',
                'area' => null,
                'location' => null,
            ],
            [
                'name' => 'Lotte Shopping Avenue',
                'area' => null,
                'location' => null,
            ],
            [
                'name' => 'Pakuwon Mall',
                'area' => null,
                'location' => null,
            ],
            [
                'name' => 'Pakuwon City Mall',
                'area' => null,
                'location' => null,
            ],
            [
                'name' => 'All Outlet',
                'area' => null,
                'location' => null,
            ],
    ]);
    }
}
