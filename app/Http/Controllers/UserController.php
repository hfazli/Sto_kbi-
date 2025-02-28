<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
  // method show get show data
  public function index()
  {
    // Ambil semua pengguna dengan role user dan viewer, kecuali admin
    $users = User::whereIn('role', ['user', 'viewer'])
      ->orderBy('created_at', 'desc')
      ->get();

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
    $request->validate([
      'id_card_number' => 'required|string|regex:/^[a-zA-Z0-9]+$/|unique:users',
      'first_name' => 'required|string|max:255',
      'last_name' => 'required|string|max:255',
      'username' => 'nullable|string|max:255|unique:users',
      'password' => 'nullable|string|min:8',
      'department' => 'required|string|max:255',
      'role' => 'required|string|in:user,viewer',
    ]);

    $user = new User();
    $user->id_card_number = $request->id_card_number;
    $user->first_name = $request->first_name;
    $user->last_name = $request->last_name;
    $user->username = $request->username;
    $user->department = $request->department;
    $user->role = $request->role;

    if ($request->filled('password')) {
      $user->password = Hash::make($request->password);
    }

    $user->save();

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
    // Pastikan hanya role viewer yang bisa diakses
    if ($user->role !== 'viewer') {
      return redirect()->route('users.index')->with('error', 'Hanya pengguna dengan role viewer yang dapat mengubah password.');
    }

    return view('User.edit-password', compact('user'));
  }

  public function updatePassword(Request $request, User $user)
  {
    // Validasi input
    $request->validate([
      'password' => 'required|string|min:8|confirmed',
    ]);

    // Update password
    $user->update([
      'password' => bcrypt($request->input('password')),
    ]);

    return redirect()->route('users.index')->with('success', 'Password berhasil diperbarui.');
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
