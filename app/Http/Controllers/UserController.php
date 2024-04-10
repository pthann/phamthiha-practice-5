<?php

namespace App\Http\Controllers;

use App\Models\User;

use Illuminate\Http\Request;

class UserController extends Controller {
    public function index() {
        $users = User::all();
        return response()->json($users);
    }

    public function store(Request $request)
    {
        // Validate the incoming request data
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|unique:users|max:255',
            'password' => 'required|string|min:8|max:255',
        ]);

        // Create the new user
        $user = User::create($validatedData);

        // Return the newly created user
        return response()->json($user, 201);
    }

    public function show($id)
    {
        // Retrieve the user by their ID
        $user = User::find($id);

        // Check if the user exists
        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        // Return the user
        return response()->json($user);
    }

    public function update(Request $request, $id)
    {
        // Retrieve the user by their ID
        $user = User::find($id);

        // Check if the user exists
        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        // Validate the incoming request data
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $id,
            'password' => 'required|string|min:8|max:255',
        ]);

        // Update the user
        $user->update($validatedData);

        // Return the updated user
        return response()->json($user);
    }

    public function destroy($id)
    {
        // Retrieve the user by their ID
        $user = User::find($id);

        // Check if the user exists
        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        // Delete the user
        $user->delete();

        // Return a success message
        return response()->json(['message' => 'User deleted successfully']);
    }
}
