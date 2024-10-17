<?php

namespace Database\Seeders;

use App\Enums\RoleCode;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (RoleCode::cases() as $roleName) {
            Role::create(['name' => $roleName, 'code' => $roleName]);
        }
        // Assuming you already have your roles defined and seeded
        $adminRole = Role::where('code', 'admin')->first();
        $operationRole = Role::where('code', 'operation')->first();

        // Assign all permissions to admin
        $allPermissions = Permission::all();
        $adminRole->permissions()->sync($allPermissions->pluck('id'));

        // Assign specific permissions to operation
        $operationPermissions = Permission::whereIn('slug', [
            'list-categories',
            'view-categories',
            'list-products',
            'view-products',
            'list-users',
            'view-users',
            'list-roles',
            'view-roles',
            'list-permissions',
            'view-permissions'
        ])->get();

        $operationRole->permissions()->sync($operationPermissions->pluck('id'));
    }
}
