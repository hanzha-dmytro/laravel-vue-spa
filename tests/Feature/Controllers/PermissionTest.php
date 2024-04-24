<?php

namespace Controllers;

use App\Models\User;
use Database\Seeders\PermissionSeeder;
use Database\Seeders\RoleSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PermissionTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(RoleSeeder::class);
        $this->seed(PermissionSeeder::class);

        $currentUser = User::factory()->create([ 'is_active' => true]);
        $currentUser->givePermissionTo('permissions:read');

        $token = $currentUser->createToken('admin:auth');
        $this->withToken($token->plainTextToken);
    }

    public function test_permissions_all()
    {
        $response = $this->getJson('/api/permissions/');

        $response->assertOk();
        $response->assertJsonStructure([ 'data' ]);
    }
}
