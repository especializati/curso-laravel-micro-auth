<?php

namespace Tests\Feature\Api;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RegisterTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_validations_register()
    {
        $response = $this->postJson('/register', []);

        $response->assertStatus(422);
    }

    public function test_register()
    {
        $response = $this->postJson('/register', [
            'name' => 'Carlos Ferreira',
            'email' => 'carlos@especializati.com.br',
            'password' => '12345678',
            'device_name' => 'test',
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

        $response->assertStatus(201);
    }
}
