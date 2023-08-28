<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Str;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->createPermissions();
        $this->createRoles();
        $this->assignPermissionsToRoles();
        $this->createUsersAndAssignRoles();
        User::factory(10)->create();
    }

    private function createPermissions()
    {
        $permissions = [
            'create-users',
            'edit-users',
            'delete-users',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }
    }

    private function createRoles()
    {
        $roles = [
            'Admin',
            'Manager',
            'Regular',
        ];

        foreach ($roles as $role) {
            Role::create(['name' => $role]);
        }
    }

    private function assignPermissionsToRoles()
    {
        $rolePermissions = [
            'Admin' => [
                'create-users',
                'edit-users',
                'delete-users',
            ],
            'Manager' => [
                'create-users',
                'edit-users',
                'delete-users',
            ],
            'Regular' => [
                'edit-users',
            ],
        ];

        foreach ($rolePermissions as $roleName => $permissions) {
            $role = Role::where('name', $roleName)->first();
            $role->givePermissionTo($permissions);
        }
    }

    private function createUsersAndAssignRoles()
    {
        $users = [
            [
                'name' => 'Admin',
                'email' => 'admin@devbatch.com',
                'email_verified_at' => now(),
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
                'remember_token' => Str::random(10)
            ],
            [
                'name' => 'Manager',
                'email' => 'manager@devbatch.com',
                'email_verified_at' => now(),
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
                'remember_token' => Str::random(10)
            ],
            [
                'name' => 'Regular',
                'email' => 'regular@devbatch.com',
                'email_verified_at' => now(),
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
                'remember_token' => Str::random(10)
            ],
        ];

        foreach ($users as $userData) {
            $user = User::create($userData);
            $user->assignRole($userData['name']);
        }
    }
}
