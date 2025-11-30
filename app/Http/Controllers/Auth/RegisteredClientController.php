<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\College;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisteredClientController extends Controller
{
    public function showRegistrationForm()
    {
        $colleges = College::all(['id', 'name']); // Fetch all colleges
        $roles = Role::all(['id', 'title']);      // Fetch all roles
        return view('auth.client-register', compact('colleges', 'roles'));
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:100',
            'state' => 'nullable|string|max:100',
            'country' => 'nullable|string|max:100',
            'website' => 'nullable|url|max:255',
            'facebook' => 'nullable|url|max:255',
            'twitter' => 'nullable|url|max:255',
            'instagram' => 'nullable|url|max:255',
            'youtube' => 'nullable|url|max:255',
            'linkedin' => 'nullable|url|max:255',
            'github' => 'nullable|url|max:255',
            'description' => 'nullable|string',
            'profile_image' => 'nullable|image|max:2048',
            'college_id' => 'nullable|exists:colleges,id',
            'role_id' => 'required|exists:roles,id',
        ]);

        // Handle profile image upload
        $imagePath = null;
        if ($request->hasFile('profile_image')) {
            $imagePath = $request->file('profile_image')->store('profile_images', 'public');
        }

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone' => $request->phone,
            'address' => $request->address,
            'city' => $request->city,
            'state' => $request->state,
            'country' => $request->country,
            'website' => $request->website,
            'facebook' => $request->facebook,
            'twitter' => $request->twitter,
            'instagram' => $request->instagram,
            'youtube' => $request->youtube,
            'linkedin' => $request->linkedin,
            'github' => $request->github,
            'description' => $request->description,
            'profile_image' => $imagePath,
            'college_id' => $request->college_id,
            'role_id' => $request->role_id,
        ]);

       // return redirect()->route('client.login')->with('success', 'Registration successful. Please login.');
    }
}
