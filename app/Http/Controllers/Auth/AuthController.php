<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials, $request->filled('remember'))) {
            $user = Auth::user();

            // Check if user is approved (for sellers)
            if ($user->role === 'seller' && $user->status !== 'approved') {
                Auth::logout();
                return back()->with('error', 'Your seller account is pending approval from SPUP Administrator');
            }

            $request->session()->regenerate();

            // Redirect based on role
            if ($user->isAdmin()) {
                return redirect()->route('admin.dashboard');
            } elseif ($user->isSeller()) {
                return redirect()->route('seller.dashboard');
            } else {
                return redirect()->route('buyer.dashboard');
            }
        }

        return back()->with('error', 'Invalid credentials');
    }

    public function showRegisterForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
            'role' => 'required|in:seller,buyer',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'status' => $request->role === 'seller' ? 'pending' : 'approved',
        ]);

        // Auto-login buyers, sellers need approval
        if ($user->role === 'buyer') {
            Auth::login($user);
            return redirect()->route('buyer.dashboard')->with('success', 'Registration successful!');
        } else {
            return redirect()->route('login')->with('success', 'Registration successful! Please wait for admin approval.');
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
}
