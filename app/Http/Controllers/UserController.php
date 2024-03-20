<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
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
        return view('user.list', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('user.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request)
    {
        // dd($request->all());
        $user = $this->userService->createUser($request->validated());
        $this->uploadImage($request, $user, self::IMAGE_FIELD);

        return redirect()->route('users.index')->with('success', 'User created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = $this->userService->getUserById($id);
        return view('user.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $user = $this->userService->getUserById($id);
        return view('user.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, string $id)
    {
//        dd($request->all());
        $user = $this->userService->updateUser($id, $request->validated());
        if(!empty($user->photo)) {
            $this->deleteOldFile($user->photo);
            $this->uploadImage($request, $user, self::IMAGE_FIELD);
        }

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
        return view('user.trashed', compact('trashedUsers'));
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
