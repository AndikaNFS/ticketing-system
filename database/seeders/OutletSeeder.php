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
                'location' => null,
            ],
            [
                'name' => 'Kemayoran',
                'location' => null,
            ],
            [
                'name' => 'Senopati',
                'location' => null,
            ],
            [
                'name' => 'Sudirman',
                'location' => null,
            ],
            [
                'name' => 'Plaza Indonesia',
                'location' => null,
            ],
            [
                'name' => 'PIK Avenue',
                'location' => null,
            ],
            [
                'name' => 'Gandaria City',
                'location' => null,
            ],
            [
                'name' => 'Senayan City',
                'location' => null,
            ],
            [
                'name' => 'Mall Of Indonesia',
                'location' => null,
            ],
            [
                'name' => 'Taman Anggrek',
                'location' => null,
            ],
            [
                'name' => 'AEON BSD',
                'location' => null,
            ],
            [
                'name' => 'Citos',
                'location' => null,
            ],
            [
                'name' => 'Gafoy',
                'location' => null,
            ],
            [
                'name' => 'Sumerecon Serpong',
                'location' => null,
            ],
            [
                'name' => 'AEON Deltamas',
                'location' => null,
            ],
            [
                'name' => 'T3 Domestic',
                'location' => null,
            ],
            [
                'name' => 'I Gusti Ngurah Rai',
                'location' => null,
            ],
            [
                'name' => 'PURI',
                'location' => null,
            ],
            [
                'name' => 'Lotte Shopping Avenue',
                'location' => null,
            ],
            [
                'name' => 'Pakuwon Mall',
                'location' => null,
            ],
            [
                'name' => 'Pakuwon City Mall',
                'location' => null,
            ],
    ]);
    }
}
