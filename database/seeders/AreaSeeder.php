<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AreaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         DB::table('areas')->insert([     
            [
                'name' => 'Jakpus',
                'location' => 'Jakarta Pusat',
                
            ],
            [
                'name' => 'Jakut',
                'location' => 'Jakarta Utara',
                
            ],
            [
                'name' => 'Jakbar',
                'location' => 'Jakarta Barat',
                
            ],
            [
                'name' => 'Jaksel',
                'location' => 'Jakarta Selatan',
                
            ],
            [
                'name' => 'Tangerang',
                'location' => 'Tangerang',
                
            ],
            [
                'name' => 'Surabaya',
                'location' => 'Surabaya',
                
            ],
            [
                'name' => 'Bali',
                'location' => 'Bali',
                
            ],
            [
                'name' => 'Medan',
                'location' => 'Medan',
                
            ],
            [
                'name' => 'Bogor',
                'location' => 'Bogor',
                
            ],
            [
                'name' => 'Cikande',
                'location' => 'Kec. Cikande, Kabupaten, Serang Banten',
                
            ],
    ]);
    }
}
