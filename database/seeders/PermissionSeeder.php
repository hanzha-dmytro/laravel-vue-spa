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

        // Permission for category model
        $this->createPermission('categories:read',   ['admin', 'moderator', 'editor']);
        $this->createPermission('categories:create', ['admin', 'moderator', 'editor']);
        $this->createPermission('categories:update', ['admin', 'moderator', 'editor']);
        $this->createPermission('categories:delete', ['admin', 'moderator', 'editor']);

        // Permission for post model
        $this->createPermission('posts:read',   ['admin', 'moderator', 'editor']);
        $this->createPermission('posts:create', ['admin', 'moderator', 'editor']);
        $this->createPermission('posts:update', ['admin', 'moderator', 'editor']);
        $this->createPermission('posts:delete', ['admin', 'moderator', 'editor']);

        // Permission for comment model
        $this->createPermission('comments:read',   ['admin', 'moderator']);
        $this->createPermission('comments:create', ['admin', 'moderator']);
        $this->createPermission('comments:update', ['admin', 'moderator']);
        $this->createPermission('comments:delete', ['admin', 'moderator']);
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
