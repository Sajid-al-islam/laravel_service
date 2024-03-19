<?php

namespace Tests\Feature;

use App\Models\User;
use App\Services\UserService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class UserServiceFeatureTest extends TestCase
{
    use RefreshDatabase;

    private $userService;

    private $authenticatedUser;

    protected function setUp(): void
    {
        parent::setUp();
        $this->userService = new UserService();
        $this->authenticatedUser = User::factory()->create();
        Auth::login($this->authenticatedUser);
    }
    public function testGetAllUsers()
    {
        $user = User::factory()->create();

        $response = $this->get('/users');
        $response->assertStatus(200);
        $response->assertViewIs('user.list');
    }

    public function testGetUserById()
    {
        $user = User::factory()->create();

        $response = $this->get('/users/' . $user->id);
        $response->assertStatus(200);
        $response->assertViewIs('user.show');
    }

    public function testCreateUser()
    {
        $userData = [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password',
            'phone_number' => '0151548484',
            'password_confirmation' => 'password'
        ];

        $response = $this->post('/users', $userData);
        $response->assertStatus(302);
        $this->assertDatabaseHas('users', ['email' => 'test@example.com']);
    }

    public function testUpdateUser()
    {
        $user = User::factory()->create();
        $updatedData = [
            'name' => 'Updated Name',
            'email' => 'updated@example.com',
            'phone_number' => '123456789',
        ];

        $response = $this->put('/users/' . $user->id, $updatedData);
        $response->assertStatus(302);
        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'name' => 'Updated Name',
            'email' => 'updated@example.com',
        ]);
    }

    public function testSoftDeleteUser()
    {
        $user = User::factory()->create();

        $response = $this->delete('/users/' . $user->id);
        $response->assertStatus(302);

        $this->assertSoftDeleted('users', ['id' => $user->id]);
    }

    public function testRestoreUser()
    {
        $user = User::factory()->create();

        $user->delete();

        $response = $this->get('/users/restore/' . $user->id);
        $response->assertStatus(302);

        $this->assertDatabaseHas('users', ['id' => $user->id, 'deleted_at' => null]);
    }
}
