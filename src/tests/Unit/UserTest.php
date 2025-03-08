<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\VarDumper\VarDumper;

class UserTest extends TestCase
{
    /** @test */
    public function it_can_create_a_user()
    {
        // Login untuk mendapatkan token
        $loginResponse = $this->postJson('/api/login', [
            'email' => 'test@gmail.com',
            'password' => 'password123',
        ]);

        $token = $loginResponse['token']; // Ambil token dari response

        $response = $this->withHeaders([
            'Authorization' => "Bearer $token"
        ])->postJson('/api/users', [
            'name' => 'Test User',
            'email' => 'testuser@example.com',
            'password' => 'password123',
            'role' => 'user',
        ]);

        $response->assertStatus(201);

        $this->assertDatabaseHas('users', ['email' => 'testuser@example.com']);
    }

    public function it_can_get_all_users()
    {
        User::factory()->count(3)->create();

        $response = $this->getJson('/api/users');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'users' => [
                    '*' => ['id', 'name', 'email', 'role', 'created_at']
                ]
            ]);
    }

    public function it_can_get_a_user_by_id()
    {
        $user = User::factory()->create();

        $response = $this->getJson("/api/users/{$user->id}");

        $response->assertStatus(200)
            ->assertJson([
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'role' => $user->role,
            ]);
    }

    /** @test */
    public function it_can_soft_delete_a_user()
    {
        $user = User::factory()->create();
        // Login untuk mendapatkan token
        $loginResponse = $this->postJson('/api/login', [
            'email' => 'test@gmail.com',
            'password' => 'password123',
        ]);

        $token = $loginResponse['token']; // Ambil token dari response

        $response = $this->withHeaders([
            'Authorization' => "Bearer $token"
        ])->deleteJson("/api/users/{$user->id}");

        $response->assertStatus(200)
            ->assertJson([
                'message' => 'User deleted successfully'
            ]);

        $this->assertSoftDeleted('users', ['id' => $user->id]);
    }

    /** @test */
    public function it_can_login_and_return_jwt_token()
    {
        $user = User::create([
            'name' => 'Login User',
            'email' => 'login@example.com',
            'password' => Hash::make('password123'),
            'role' => 'admin'
        ]);

        $response = $this->postJson('/api/login', [
            'email' => 'login@example.com',
            'password' => 'password123',
        ]);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'token'
            ]);
    }
}
