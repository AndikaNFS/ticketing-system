<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class InventoryRolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Role yang mendapatkan full akses inventory
        $fullAccessRoles = ['superadmin', 'admin', 'admin1'];

        $fullPermissions = [
            'category.view',
            'category.create',
            'category.edit',
            'category.delete',

            'inventory.view',
            'inventory.create',
            'inventory.edit',
            'inventory.delete',

            'asset.view',
            'asset.create',
            'asset.edit',
            'asset.delete',
            
            'asset.transfer',
            // 'transfer.view',

            'repair.view',
            'repair.create',
            'repair.complete',

            'inventory.dashboard',
            'inventory.report',
            'inventory.export',
        ];

        foreach ($fullAccessRoles as $roleName) {
            $role = Role::firstOrCreate([
                'name' => $roleName,
                'guard_name' => 'web',
            ]);

            $role->givePermissionTo($fullPermissions);
        }

        // Direksi hanya dashboard dan report
        $direksi = Role::firstOrCreate([
            'name' => 'direksi',
            'guard_name' => 'web',
        ]);

        $direksi->givePermissionTo([
            'inventory.dashboard',
            'inventory.report',
        ]);

        app(PermissionRegistrar::class)->forgetCachedPermissions();
    }
}
