<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            // [
            // 'name' => 'Admin IT',
            // 'email' => 'itrrchocolate@gmail.com',
            // 'password' => bcrypt('*mhb2020'),

            // ],
            // [
            // 'name' => 'Andika Nur Sasmito',
            // 'email' => 'andika@gmail.com',
            // 'password' => bcrypt('andikans'),
            // ],
            // [
            // 'name' => 'Santo',
            // 'email' => 'santo@gmail.com',
            // 'password' => bcrypt('santo123'),
            // ],
            // [
            // 'name' => 'Asep',
            // 'email' => 'asep@gmail.com',
            // 'password' => bcrypt('asep123'),
            // ],
            [
            'name' => 'Kodam',
            'email' => 'kodam@gmail.com',
            'password' => bcrypt('kodam123'),
            ],
        ]);
    }
}
