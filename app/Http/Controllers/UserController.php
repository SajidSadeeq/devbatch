<?php

namespace App\Http\Controllers;

use Illuminate\Auth\Access\AuthorizationException;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use Illuminate\Support\Facades\Gate;


class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Check if the authenticated user can view any users
        if (Gate::allows('viewAny', User::class)) {
            $users = User::all();
            return response()->json(['users' => $users]);
        }

        // If not authorized, return a 403 Forbidden response
        return response()->json(['message' => 'You do not have permission to view users.'], 403);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request)
    {
        // Check if the authenticated user can create users
        if (Gate::allows('create', User::class)) {
            $data = $request->validated();
            $user = User::create($data);

            return response()->json(['user' => $user], 201);
        }

        // If not authorized, return a 403 Forbidden response
        return response()->json(['message' => 'You do not have permission to create users.'], 403);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        // Check if the authenticated user can update this user
        if (Gate::allows('update', $user)) {
            $data = $request->validated();
            $user->update($data);

            return response()->json(['user' => $user]);
        }

        // If not authorized, return a 403 Forbidden response
        return response()->json(['message' => 'You do not have permission to update this user.'], 403);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        // Check if the authenticated user can delete this user
        if (Gate::allows('delete', $user)) {
            $user->delete();
            return response()->json(['message' => 'User deleted successfully']);
        }

        // If not authorized, return a 403 Forbidden response
        return response()->json(['message' => 'You do not have permission to delete this user.'], 403);
    }
}
