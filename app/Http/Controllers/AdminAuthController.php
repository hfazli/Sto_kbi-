<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Admin;

class AdminAuthController extends Controller
{
  public function showLoginForm()
  {
    return view('login-admin');
  }

  public function login(Request $request)
  {
    $request->validate([
      'username' => 'required',
      'password' => 'required',
    ]);

    $credentials = $request->only('username', 'password');

    if (Auth::guard('admin')->attempt($credentials)) {
      $admin = Auth::guard('admin')->user();

      $token = $admin->createToken('AdminToken')->plainTextToken;

      // Redirect to the dashboard with the token and success message
      return redirect()->route('dashboard')->with(['token' => $token, 'success' => 'Login successful!']);
    }

    return back()->with('error', 'Invalid username or password');
  }

  public function logout(Request $request)
  {
    Auth::guard('admin')->logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect('/');
  }
}
