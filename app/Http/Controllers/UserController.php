<?php

namespace App\Http\Controllers;

use App\Http\Traits\FileUploadTrait;
use App\Services\UserService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    use FileUploadTrait;
    private $userService;
    const IMAGE_FIELD = 'photo';

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = $this->userService->getAllUsers();
        return view('user.list', ['users', $users]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('users.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = $this->userService->createUser($request->validated());
        $this->uploadImage($request->validated(), $user, self::IMAGE_FIELD);

        return redirect()->route('users.index')->with('success', 'User created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = $this->userService->getUserById($id);
        return view('users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $user = $this->userService->getUserById($id);
        return view('users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $user = $this->userService->updateUser($id, $request->validated());
        $this->deleteOldFile($user->photo);
        $this->uploadImage($request->validated(), $user, self::IMAGE_FIELD);

        return redirect()->route('users.index')->with('success', 'User updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->userService->deleteUser($id);
        return redirect()->route('users.index')->with('success', 'User deleted successfully.');
    }

    public function trashed()
    {
        $trashedUsers = $this->userService->getTrashedUsers();
        return view('users.trashed', compact('trashedUsers'));
    }


    public function restore($id)
    {
        $this->userService->restoreUser($id);
        return redirect()->route('users.index')->with('success', 'User restored successfully.');
    }

    public function forceDelete($id)
    {
        $this->userService->forceDeleteUser($id);
        return redirect()->route('users.trashed')->with('success', 'User permanently deleted.');
    }
}
