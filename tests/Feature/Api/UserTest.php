<?php

namespace Tests\Feature\Api;

use App\Models\Permission;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_get_users_unauthenticated()
    {
        $response = $this->getJson('/users');
        
        $response->assertStatus(401);
    }

    public function test_get_users_unauthorized()
    {
        $user = User::factory()->create();
        $token = $user->createToken('test')->plainTextToken;

        $response = $this
                        ->withHeaders([
                            'Authorization' => "Bearer {$token}"
                        ])
                        ->getJson('/users');
        
        $response->assertStatus(403);
    }

    public function test_get_users()
    {
        $permission = Permission::factory()->create(['name' => 'users']);

        $user = User::factory()->create();
        $token = $user->createToken('test')->plainTextToken;

        $user->permissions()->attach($permission);

        $response = $this
                        ->withHeaders([
                            'Authorization' => "Bearer {$token}"
                        ])
                        ->getJson('/users');
        
        $response->assertStatus(200);
    }

    public function test_count_users()
    {
        $permission = Permission::factory()->create(['name' => 'users']);

        User::factory()->count(10)->create();

        $user = User::first();
        $token = $user->createToken('test')->plainTextToken;

        $user->permissions()->attach($permission);

        $response = $this
                        ->withHeaders([
                            'Authorization' => "Bearer {$token}"
                        ])
                        ->getJson('/users');
        
        $response->assertJsonCount(10, 'data');
        $response->assertStatus(200);
    }

    public function test_get_fail_user()
    {
        $permission = Permission::factory()->create(['name' => 'users']);

        $user = User::factory()->create();
        $token = $user->createToken('test')->plainTextToken;

        $user->permissions()->attach($permission);

        $response = $this
                        ->withHeaders([
                            'Authorization' => "Bearer {$token}"
                        ])
                        ->getJson("/users/fake_value");
                        
        $response->assertStatus(404);
    }

    public function test_get_user()
    {
        $permission = Permission::factory()->create(['name' => 'users']);

        $user = User::factory()->create();
        $token = $user->createToken('test')->plainTextToken;

        $user->permissions()->attach($permission);

        $response = $this
                        ->withHeaders([
                            'Authorization' => "Bearer {$token}"
                        ])
                        ->getJson("/users/{$user->uuid}");
                        
        $response->assertStatus(200);
    }

    public function test_validations_store_user()
    {
        $permission = Permission::factory()->create(['name' => 'users']);

        $user = User::factory()->create();
        $token = $user->createToken('test')->plainTextToken;

        $user->permissions()->attach($permission);

        $response = $this
                        ->withHeaders([
                            'Authorization' => "Bearer {$token}"
                        ])
                        ->postJson('/users', []);
                        
        $response->assertStatus(422);
    }

    public function test_store_user()
    {
        $permission = Permission::factory()->create(['name' => 'users']);

        $user = User::factory()->create();
        $token = $user->createToken('test')->plainTextToken;

        $user->permissions()->attach($permission);

        $response = $this
                        ->withHeaders([
                            'Authorization' => "Bearer {$token}"
                        ])
                        ->postJson('/users', [
                            'name' => 'Carlos Ferreira',
                            'email' => 'carlos@especializati.com.br',
                            'password' => '12345678',
                        ]);
                        
        $response->assertStatus(201);
    }

    public function test_validation_404_update_user()
    {
        $permission = Permission::factory()->create(['name' => 'users']);

        $user = User::factory()->create();
        $token = $user->createToken('test')->plainTextToken;

        $user->permissions()->attach($permission);

        $response = $this
                        ->withHeaders([
                            'Authorization' => "Bearer {$token}"
                        ])
                        ->putJson('/users/fake_user', [
                            'name' => 'Carlos Ferreira',
                            'email' => 'carlos@especializati.com.br',
                        ]);
                        
        $response->assertStatus(404);
    }

    public function test_validations_update_user()
    {
        $permission = Permission::factory()->create(['name' => 'users']);

        $user = User::factory()->create();
        $token = $user->createToken('test')->plainTextToken;

        $user->permissions()->attach($permission);

        $response = $this
                        ->withHeaders([
                            'Authorization' => "Bearer {$token}"
                        ])
                        ->putJson("/users/{$user->uuid}", []);
                        
        $response->assertStatus(422);
    }

    public function test_update_user()
    {
        $permission = Permission::factory()->create(['name' => 'users']);

        $user = User::factory()->create();
        $token = $user->createToken('test')->plainTextToken;

        $user->permissions()->attach($permission);

        $response = $this
                        ->withHeaders([
                            'Authorization' => "Bearer {$token}"
                        ])
                        ->putJson("/users/{$user->uuid}", [
                            'name' => 'User Updated',
                            'email' => 'carlos@especializati.com.br',
                        ]);
                        
        $response->assertStatus(200);
    }

    public function test_validation_404_delete_user()
    {
        $permission = Permission::factory()->create(['name' => 'users']);

        $user = User::factory()->create();
        $token = $user->createToken('test')->plainTextToken;

        $user->permissions()->attach($permission);

        $response = $this
                        ->withHeaders([
                            'Authorization' => "Bearer {$token}"
                        ])
                        ->deleteJson('/users/fake_user');
                        
        $response->assertStatus(404);
    }

    public function test_delete_user()
    {
        $permission = Permission::factory()->create(['name' => 'users']);

        $user = User::factory()->create();
        $token = $user->createToken('test')->plainTextToken;

        $user->permissions()->attach($permission);

        $response = $this
                        ->withHeaders([
                            'Authorization' => "Bearer {$token}"
                        ])
                        ->deleteJson("/users/{$user->uuid}");
                        
        $response->assertStatus(200);
    }
}
