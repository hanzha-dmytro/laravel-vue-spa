<?php

namespace Controllers\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthenticateTest extends TestCase
{
    use RefreshDatabase;

    public function test_users_can_authenticate(): void
    {
        $user = User::factory()->create([ 'is_active' => true ]);
        $response = $this->postJson('/api/auth/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $this->assertAuthenticated();
        $response->assertStatus(200);
    }

    public function test_users_can_not_authenticate_with_invalid_password(): void
    {
        $user = User::factory()->create([ 'is_active' => true ]);
        $response = $this->postJson('/api/auth/login', [
            'email' => $user->email,
            'password' => 'wrong-password',
        ]);

        $this->assertGuest();
        $response->assertStatus(422);
    }

    public function test_users_can_logout(): void
    {
        $user = User::factory()->create([ 'is_active' => true ]);
        $token = $user->createToken('admin:auth');
        $response = $this->withToken($token->plainTextToken)->postJson('/api/auth/logout');

        $response->assertNoContent();
        $response->assertStatus(204);
        $this->assertGuest();
    }
}
