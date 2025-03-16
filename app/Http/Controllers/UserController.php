<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
  // method show get show data
  public function index()
  {
    $users = User::all();
    return view('User.index', compact('users'));
  }

  //method show create
  public function create()
  {
    return view('User.create');
  }

  // method post create user
  public function store(Request $request)
  {
    $validatedData = $request->validate([
      'id_card_number' => 'required|string|max:255|unique:users',
      'first_name' => 'required|string|max:255',
      'last_name' => 'required|string|max:255',
      'username' => 'nullable|string|max:255|unique:users',
      'department' => 'required|string|max:255',
      'role' => 'required|string|in:admin,user,viewer',
      'password' => 'nullable|string|min:3|required_if:role,admin',
    ]);

    if ($request->role == 'admin') {
      $validatedData['password'] = Hash::make($request->password);
      Admin::create($validatedData);
    } else {
      $validatedData['password'] = Hash::make('default_password'); // Set a default password for non-admin users
      User::create($validatedData);
    }



    return redirect()->route('users.index')->with('success', 'User created successfully.');
  }

  // method post delete user
  public function destroy(User $user)
  {
    $user->delete();
    return redirect()->route('users.index')->with('success', 'User deleted successfully.');
  }

  public function editPassword(User $user)
  {
    return view('User.edit-password', compact('user'));
  }

  public function updatePassword(Request $request, User $user)
  {
    $validatedData = $request->validate([
      'password' => 'required|string|min:8|confirmed',
    ]);

    $user->password = Hash::make($validatedData['password']);
    $user->save();

    return redirect()->route('users.index')->with('success', 'Password updated successfully.');
  }

  public function login(Request $request)
  {
    $request->validate([
      'id_card_number' => 'required|string|regex:/^[a-zA-Z0-9]+$/',
    ]);

    $user = User::where('id_card_number', $request->id_card_number)->first();

    if ($user) {
      Auth::login($user);
      $user->update([
        'last_login' => now(),
      ]);
      return redirect()->route('sto.index')->with('success', 'Login successful.');
    } else {
      return redirect()->back()->with('error', 'Invalid ID Card Number.');
    }
  }
}
