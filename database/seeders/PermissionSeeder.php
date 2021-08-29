<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Permission for user model
        $this->createPermission('users:read',   ['admin']);
        $this->createPermission('users:create', ['admin']);
        $this->createPermission('users:update', ['admin']);
        $this->createPermission('users:delete', ['admin']);

        // Permission for role model
        $this->createPermission('roles:read',   ['admin']);
        $this->createPermission('roles:create', ['admin']);
        $this->createPermission('roles:update', ['admin']);
        $this->createPermission('roles:delete', ['admin']);

        // Permission for permission model
        $this->createPermission('permissions:read', ['admin']);
    }

    /**
     * Create the permission and give it to the roles
     *
     * @param string $name
     * @param array $roles
     * @return void
     */
    private function createPermission(string $name, array $roles): void {
        $permission = Permission::updateOrCreate(['slug' => $name]);

        Role::whereIn('slug', $roles)->each(function ($role) use ($permission) {
            $role->givePermissionTo($permission->slug);
        });
    }
}
