<?php

namespace Tests\Unit;

use App\Models\User;
use App\Services\UserService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class UserServiceTest extends TestCase
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

    protected function tearDown(): void
    {
        Auth::logout();
        parent::tearDown();
    }

    public function testGetAllUsers()
    {
        User::factory()->count(3)->create();

        $users = $this->userService->getAllUsers();

        $this->assertCount(3, $users);
    }

    public function testGetUserById()
    {
        $user = User::factory()->create();

        $retrievedUser = $this->userService->getUserById($user->id);

        $this->assertEquals($user->id, $retrievedUser->id);
    }

    public function testCreateUser()
    {
        $userData = [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password',
        ];
        $user = $this->userService->createUser($userData);

        $this->assertDatabaseHas('users', [
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);
    }

    public function testUpdateUser()
    {
        $user = User::factory()->create();

        $updatedData = [
            'name' => 'Updated Name',
            'email' => 'updated@example.com',
        ];
        $updatedUser = $this->userService->updateUser($user->id, $updatedData);

        $this->assertEquals($updatedData['name'], $updatedUser->name);
        $this->assertEquals($updatedData['email'], $updatedUser->email);
    }

    public function testDeleteUser()
    {
        $user = User::factory()->create();

        $deletedUser = $this->userService->deleteUser($user->id);

        $this->assertSoftDeleted($deletedUser);
    }

    public function testGetTrashedUsers()
    {
        $user = User::factory()->create();

        $this->userService->deleteUser($user->id);
        $trashedUsers = $this->userService->getTrashedUsers();

        $this->assertCount(1, $trashedUsers);
    }

    public function testRestoreUser()
    {
        $user = User::factory()->create();

        $this->userService->deleteUser($user->id);
        $restoredUser = $this->userService->restoreUser($user->id);

        $this->assertNotSoftDeleted($restoredUser);
    }

    public function testForceDeleteUser()
    {
        $user = User::factory()->create();

        $this->userService->deleteUser($user->id);
        $this->userService->forceDeleteUser($user->id);

        $this->assertDatabaseMissing('users', ['id' => $user->id]);
    }
}
