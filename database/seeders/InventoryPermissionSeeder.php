<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class InventoryPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        app(PermissionRegistrar::class)->forgetCachedPermissions();

        $permissions = [
            // Category
            'category.view',
            'category.create',
            'category.edit',
            'category.delete',

            // Inventory
            'inventory.view',
            'inventory.create',
            'inventory.edit',
            'inventory.delete',
            
            // Asset
            'asset.view',
            'asset.create',
            'asset.edit',
            'asset.delete',
            
            // Transfer
            'asset.transfer',
            'asset.view',

            // Repair
            'repair.view',
            'repair.create',
            'repair.complete',

            // Dashboard & Report
            'inventory.dashboard',
            'inventory.report',
            'inventory.export',

        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate([
                'name' => $permission,
                'guard_name' => 'web',
            ]);
        }

        app(PermissionRegistrar::class)->forgetCachedPermissions();
    }
}
