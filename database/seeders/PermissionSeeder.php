<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Define permissions for CRUD operations on categories and products
        $permissions = [
            ['name' => 'create categories', 'slug' => 'create-categories'],
            ['name' => 'list categories', 'slug' => 'list-categories'],
            ['name' => 'view categories', 'slug' => 'view-categories'],
            ['name' => 'update categories', 'slug' => 'update-categories'],
            ['name' => 'delete categories', 'slug' => 'delete-categories'],

            ['name' => 'create products', 'slug' => 'create-products'],
            ['name' => 'update products', 'slug' => 'update-products'],
            ['name' => 'delete products', 'slug' => 'delete-products'],

            ['name' => 'list users', 'slug' => 'list-users'],
            ['name' => 'create users', 'slug' => 'create-users'],
            ['name' => 'update users', 'slug' => 'update-users'],
            ['name' => 'delete users', 'slug' => 'delete-users'],

            ['name' => 'create roles', 'slug' => 'create-roles'],
            ['name' => 'list roles', 'slug' => 'list-roles'],
            ['name' => 'update roles', 'slug' => 'update-roles'],
            ['name' => 'delete roles', 'slug' => 'delete-roles'],

            ['name' => 'create permissions', 'slug' => 'create-permissions'],
            ['name' => 'list permissions', 'slug' => 'list-permissions'],
            ['name' => 'update permissions', 'slug' => 'update-permissions'],
            ['name' => 'delete permissions', 'slug' => 'delete-permissions'],
        ];

        foreach ($permissions as $permission) {
            Permission::create($permission);
        }
    }
}
