<?php

namespace Controllers;

use App\Models\Role;
use App\Models\User;
use Database\Seeders\PermissionSeeder;
use Database\Seeders\RoleSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RoleTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(RoleSeeder::class);
        $this->seed(PermissionSeeder::class);

        $currentUser = User::factory()->create([ 'is_active' => true]);
        $currentUser->givePermissionTo(['roles:read', 'roles:create', 'roles:update', 'roles:delete']);

        $token = $currentUser->createToken('admin:auth');
        $this->withToken($token->plainTextToken);
    }

    public function test_roles_list()
    {
        $response = $this->getJson('/api/roles/');

        $response->assertOk();
        $response->assertJsonStructure([ 'data', 'links', 'meta' ]);
    }

    public function test_roles_show()
    {
        $role = Role::factory()->create();
        $response = $this->getJson('/api/roles/'.$role->id);

        $response->assertOk();
        $response->assertJsonPath('data.name', $role->name);
    }

    public function test_roles_store()
    {
        $response = $this->postJson('/api/roles/', [
            'name' => 'Test role',
            'slug' => 'test-role',
        ]);

        $response->assertCreated();
        $response->assertJsonPath('data.name', 'Test role');
        $this->assertDatabaseHas('roles', [ 'slug' => 'test-role' ]);
    }

    public function test_roles_destroy()
    {
        $role = Role::factory()->create();
        $this->assertDatabaseHas('roles', [ 'id' => $role->id ]);

        $response = $this->deleteJson('api/roles/'.$role->id);

        $response->assertOk();
        $this->assertDatabaseMissing('roles', [ 'id' => $role->id ]);
    }

    public function test_roles_all()
    {
        $response = $this->getJson('/api/roles/');

        $response->assertOk();
        $response->assertJsonStructure([ 'data' ]);
    }
}
