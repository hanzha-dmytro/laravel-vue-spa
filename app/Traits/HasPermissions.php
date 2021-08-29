<?php

namespace App\Traits;

use App\Models\Permission;

/**
 * App\Traits\HasPermissions
 *
 * @property \App\Models\Permission $permissions
 */

trait HasPermissions
{
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function permissions(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->morphToMany(Permission::class, 'permissionables');
    }

    /**
     * @param string $permission
     * @return boolean
     */
    public function hasPermissionTo(string $permission): bool
    {
        return $this->permissions->contains('slug', $permission);
    }

    /**
     * @param string|array $permissions
     * @return void
     */
    public function givePermissionTo(string|array $permissions): void
    {
        $this->permissions()->syncWithoutDetaching($this->getPermission($permissions));
        $this->load('permissions');
    }

    /**
     * @param string|array $permissions
     * @return void
     */
    public function revokePermissionTo(string|array $permissions): void
    {
        $this->permissions()->detach($this->getPermission($permissions));
        $this->load('permissions');
    }

    /**
     * @param array $permissions
     * @return void
     */
    public function syncPermissions(array $permissions): void
    {
        $this->permissions()->sync($this->getPermission($permissions));
        $this->load('permissions');
    }

    /**
     * @param string|array $permissions
     * @return mixed
     */
    protected function getPermission(string|array $permissions): mixed
    {
        return is_string($permissions)
            ? Permission::where('slug', $permissions)->get()
            : Permission::whereIn('slug', $permissions)->get();
    }
}
