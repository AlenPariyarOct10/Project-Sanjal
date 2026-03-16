<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\College;
use App\Models\Role;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegisteredClientController extends Controller
{
    public function showRegistrationForm()
    {
        $colleges = College::all(['id', 'name']); // Fetch all colleges
        $roles = Role::all(['id', 'title']); // Fetch all roles

        return view('auth.client-register', compact('colleges', 'roles'));
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'college_id' => 'required|exists:colleges,id',
            'role_id' => 'required|exists:roles,id',
            'terms' => 'accepted',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'college_id' => $request->college_id,
            'role_id' => $request->role_id,
            'status' => false, // Set to false until verified
        ]);

        event(new Registered($user));

        return redirect()->route('client.login')->with('success', 'Registration successful. A verification link has been sent to your email. Please verify your email to activate your account.');
    }
}
