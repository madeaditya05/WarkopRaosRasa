<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthController extends Controller
{
    // Method untuk menampilkan halaman login
    public function showLoginForm()
    {
        return view('login');
    }

    // Proses validasi data login
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);
    
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            // Setelah login berhasil, akan diproses oleh authenticated method
            return $this->redirectBasedOnUserGroup($request->user());
        }
    
        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ]);
    }

    // Method untuk menangani logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }

    // Fungsi untuk mengarahkan user setelah login
    private function redirectBasedOnUserGroup($user)
    {
        if ($user->user_group === 'admin') {
            return redirect('/menu_makanan');
        }

        if ($user->user_group === 'customer') {
            return redirect('/dashboard');
        }
    }
}
