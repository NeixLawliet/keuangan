<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // Menampilkan halaman login
    public function index()
    {
        return view('auth.login');
    }

    // Proses login
    public function store(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
        
            $user = Auth::user();
            session()->flash('success', "Selamat datang, {$user->name}!");

            // Simpan flash session untuk modal hanya jika role = admin_besar
            if ($user->role === 'admin_besar') {
                session()->flash('show_welcome_modal', true);
            }
        
            // Redirect berdasarkan role
            if ($user->role === 'admin_keuangan') {
                return redirect()->route('keuangan.index');
            } elseif ($user->role === 'admin_inventory') {
                return redirect()->route('inventory.index');
            } elseif ($user->role === 'admin_besar') {
                return redirect()->route('dashboard'); 
            }
        }

        session()->flash('error', 'Username atau password salah.');
        return back()->withInput();
    }


    // Logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Logout berhasil!');
    }
}
