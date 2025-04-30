<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $superAdminRole = Role::create([
            'name' => 'superadmin'
        ]);

        $adminRole = Role::create([
            'name' => 'admin'
        ]);

        $userRole = Role::create([
            'name' => 'user'
        ]);

        $userSuperAdmin = User::create([
            'name' => 'SuperAdmin',
            'email' => 'superadmin@gmail.com',
            'password' => bcrypt('*mhb2020')
        ]);
        $userAdmin = User::create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('*rci2120')
        ]);

        $user = User::create([
            [
                'name' => 'User',
                'email' => 'user@gmail.com',
                'password' => bcrypt('userlogin')
            ],
        ]);

        $userSuperAdmin->assignRole($superAdminRole);
        $userAdmin->assignRole($adminRole);
        $user->assignRole($userRole);

        // DB::table('users')->insert([
        //     [
        //     'name' => 'Admin IT',
        //     'email' => 'itrrchocolate@gmail.com',
        //     'password' => bcrypt('*mhb2020'),

        //     ],
        //     [
        //     'name' => 'Andika Nur Sasmito',
        //     'email' => 'andika@gmail.com',
        //     'password' => bcrypt('andikans'),
        //     ],
        //     [
        //     'name' => 'Santo',
        //     'email' => 'santo@gmail.com',
        //     'password' => bcrypt('santo123'),
        //     ],
        //     [
        //     'name' => 'Asep',
        //     'email' => 'asep@gmail.com',
        //     'password' => bcrypt('asep123'),
        //     ],
        //     [
        //     'name' => 'Kodam',
        //     'email' => 'kodam@gmail.com',
        //     'password' => bcrypt('kodam123'),
        //     ],
        // ]);
    }
}
