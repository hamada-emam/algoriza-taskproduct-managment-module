<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (Role::all() as $role) {
            User::create([
                'name' => ucfirst($role->name) . " User",
                'email' => strtolower("{$role->name}user@example.com"),
                'password' => Hash::make('123456'),
                'role_id' => $role->id,
                'email_verified_at' => now(),
            ]);
        }
    }
}
