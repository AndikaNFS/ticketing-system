<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Laptop',
                'description' => 'Laptop/Notebook',
            ],
            [
                'name' => 'PC',
                'description' => 'Desktop PC / Computer',
            ],
            [
                'name' => 'Tablet',
                'description' => 'Tablet Computer',
            ],
            [
                'name' => 'Smartphone',
                'description' => 'Smartphone / Mobile Phone',
            ],
            [
                'name' => 'Monitor',
                'description' => 'Computer Monitor',
            ],
            [
                'name' => 'Keyboard',
                'description' => 'Computer Keyboard',
            ],
            [
                'name' => 'Mouse',
                'description' => 'Computer Mouse',
            ],
            [
                'name' => 'Printer',
                'description' => 'Printer / Scanner',
            ],
            [
                'name' => 'Networking',
                'description' => 'Networking Equipment',
            ],
            [
                'name' => 'Other',
                'description' => 'Other Equipment',
            ],

        ];

        foreach ($categories as $category) {
            Category::updateOrCreate(
                ['name' => $category['name']],
                [
                    'description' => $category['description'],
                    'is_active' => true,  
                ]
            );
        }
    }
}
