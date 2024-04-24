<?php

namespace Controllers;

use App\Models\Role;
use App\Models\User;
use Database\Seeders\PermissionSeeder;
use Database\Seeders\RoleSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(RoleSeeder::class);
        $this->seed(PermissionSeeder::class);

        $currentUser = User::factory()->create([ 'is_active' => true]);
        $currentUser->givePermissionTo(['users:read', 'users:create', 'users:update', 'users:delete']);

        $token = $currentUser->createToken('admin:auth');
        $this->withToken($token->plainTextToken);
    }

    public function test_users_list()
    {
        $response = $this->getJson('/api/users/');

        $response->assertOk();
        $response->assertJsonStructure([ 'data', 'links', 'meta' ]);
    }

    public function test_users_show()
    {
        $user = User::factory()->create();
        $response = $this->getJson('/api/users/'.$user->id);

        $response->assertOk();
        $response->assertJsonPath('data.name', $user->name);
    }

    public function test_users_store()
    {
        $response = $this->postJson('/api/users/', [
            'role_id'     => Role::inRandomOrder()->first()?->id,
            'name'        => 'Test user',
            'email'       => 'test@example.com',
            'is_active'   => true,
        ]);

        $response->assertCreated();
        $response->assertJsonPath('data.name', 'Test user');
        $this->assertDatabaseHas('users', [ 'email' => 'test@example.com' ]);
    }

    public function test_users_destroy()
    {
        $user = User::factory()->create();
        $this->assertDatabaseHas('users', [ 'id' => $user->id ]);

        $response = $this->deleteJson('api/users/'.$user->id);

        $response->assertOk();
        $this->assertDatabaseMissing('users', [ 'id' => $user->id ]);
    }

    public function test_users_all()
    {
        $response = $this->getJson('/api/users/');

        $response->assertOk();
        $response->assertJsonStructure([ 'data' ]);
    }
}
