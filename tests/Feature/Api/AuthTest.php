<?php

namespace Tests\Feature\Api;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AuthTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_validations_auth()
    {
        $response = $this->postJson('/auth', []);

        $response->assertStatus(422);
    }

    public function test_error_password_auth()
    {
        User::factory()->create([
            'email' => 'carlos@especializati.com.br'
        ]);

        $response = $this->postJson('/auth', [
            'email' => 'carlos@especializati.com.br',
            'password' => 'fakepassword',
            'device_name' => 'test'
        ]);

        $response->assertStatus(422);
    }

    public function test_auth()
    {
        $user = User::factory()->create([
            'email' => 'carlos@especializati.com.br'
        ]);

        $response = $this->postJson('/auth', [
            'email' => 'carlos@especializati.com.br',
            'password' => 'password',
            'device_name' => 'test'
        ]);

        $response->assertJsonStructure([
            'data' => [
                'identify',
                'name',
                'email',
                'permissions' => []
            ],
            'token'
        ]);

        $response->assertStatus(200);
    }

    public function test_error_logout()
    {
        $response = $this->postJson('/logout');

        $response->assertStatus(401);
    }

    public function test_logout()
    {
        $user = User::factory()->create();
        $token = $user->createToken('test')->plainTextToken;

        $response = $this
                        ->withHeaders([
                            'Authorization' => "Bearer {$token}"
                        ])
                        ->postJson('logout');

        $response->assertStatus(200);
    }

    public function test_error_get_me()
    {
        $response = $this->getJson('/me');

        $response->assertStatus(401);
    }

    public function test_get_me()
    {
        $user = User::factory()->create();
        $token = $user->createToken('test')->plainTextToken;

        $response = $this
                        ->withHeaders([
                            'Authorization' => "Bearer {$token}"
                        ])
                        ->getJson('/me');

        $response->assertStatus(200);
    }
}
