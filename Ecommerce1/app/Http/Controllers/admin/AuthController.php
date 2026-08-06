<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    // Show user login page
    public function showLogin()
    {
        if (Session::has('user')) {
            $role = Session::get('user.role');
            if ($role === 'Administrator') {
                return redirect()->route('admin.dashboard');
            }
            return redirect()->route('home');
        }
        return view('auth.user_login');
    }

    // Show admin login page
    public function showAdminLogin()
    {
        if (Session::has('user')) {
            $role = Session::get('user.role');
            if ($role === 'Administrator') {
                return redirect()->route('admin.dashboard');
            }
            return redirect()->route('home');
        }
        return view('auth.admin_login');
    }

    // Handle user login (Database users only)
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6'
        ]);

        // 1. BLOCK: If someone tries to use the hardcoded Admin email here
        if ($request->email === 'admin@gmail.com') {
            return back()->withErrors(['email' => 'Admin cannot login from user login page. Please use admin login.']);
        }

        // 2. Check Database for normal users
        $user = User::where('email', $request->email)->first();

        if (!$user || $user->password !== $request->password) {
            return back()->withErrors(['email' => 'Invalid credentials.']);
        }

        // 3. Login the normal user
        Session::put('user', [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'role' => $user->role // Make sure DB has 'role' column
        ]);
        
        return redirect()->route('home')->with('success', 'Welcome back!');
    }

    // Handle admin login (HARDCODED ADMIN + Database Admins)
    public function adminLogin(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6'
        ]);

        // ============================================
        // 1. CHECK HARDCODED ADMIN FIRST
        // ============================================
        if ($request->email === 'admin@gmail.com' && $request->password === 'admin123') {
            
            Session::put('user', [
                'id' => 999, // Dummy ID
                'name' => 'Hardcoded Admin',
                'email' => 'admin@gmail.com',
                'role' => 'Administrator'
            ]);
            
            return redirect()->route('admin.dashboard')->with('success', 'Welcome Admin!');
        }

        // ============================================
        // 2. CHECK DATABASE (In case you add an Admin to DB later)
        // ============================================
        $user = User::where('email', $request->email)->first();

        if (!$user || $user->password !== $request->password || $user->role !== 'Administrator') {
            return back()->withErrors(['email' => 'Invalid admin credentials.'])->withInput($request->only('email'));
        }

        Session::put('user', [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'role' => $user->role
        ]);
        
        return redirect()->route('admin.dashboard')->with('success', 'Welcome Admin!');
    }

    // Handle logout
    public function logout(Request $request)
    {
        $role = Session::get('user.role');
        
        Session::forget('user');
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        if ($role === 'Administrator') {
            return redirect('/admin')->with('success', 'Logged out successfully.');
        }
        
        return redirect('/')->with('success', 'Logged out successfully.');
    }
}