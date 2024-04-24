<?php

namespace Tests\Feature\Traits;

use App\Models\Permission;
use App\Models\User;
use Database\Seeders\PermissionSeeder;
use Database\Seeders\RoleSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HasPermissionsTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(RoleSeeder::class);
        $this->seed(PermissionSeeder::class);
    }

    public function test_can_give_permission_to_user()
    {
        $user = User::factory()->create();
        $permission = Permission::factory()->create(['slug' => 'tests:example']);

        // Check negative variant
        $this->assertFalse($user->hasPermissionTo($permission->slug));

        // Give permission to current user
        $user->givePermissionTo([$permission->slug]);

        // Check positive variant
        $this->assertTrue($user->hasPermissionTo($permission->slug));
    }

    public function test_can_revoke_permission_from_user()
    {
        $user = User::factory()->create();
        $permission = Permission::factory()->create(['slug' => 'tests:example']);

        // Give permission to current user
        $user->givePermissionTo([$permission->slug]);

        // Check positive variant
        $this->assertTrue($user->hasPermissionTo($permission->slug));

        // Revoke permission from current user
        $user->revokePermissionTo([$permission->slug]);

        // Check negative variant
        $this->assertFalse($user->hasPermissionTo($permission->slug));
    }

    public function test_can_sync_permission_for_user()
    {
        $user = User::factory()->create();
        $permission = Permission::factory()->create(['slug' => 'tests:example']);

        // Sync permissions for current user
        $user->syncPermissions([$permission->slug]);

        $this->assertTrue($user->hasPermissionTo($permission->slug));
        $this->assertCount(1, $user->permissions);
    }
}
