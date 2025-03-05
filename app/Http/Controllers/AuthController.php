<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    // Menampilkan halaman login
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // Proses login
    public function login(Request $request)
    {
        $request->validate([
            'user_nama' => 'required',
            'user_password' => 'required'
        ]);

        // Cek apakah username ditemukan
        $user = User::where('user_nama', $request->user_nama)->first();

        if ($user && Hash::check($request->user_password, $user->user_password)) {
            Auth::login($user);
            return redirect()->route('homeuser'); // Pastikan route welcome sudah dibuat
        }

        return back()->with('error', 'Username atau password salah!');
    }

    // Logout
    public function logout()
    {
        Auth::logout(); // Logout pengguna
        return redirect()->route('login')->with('success', 'Anda telah logout.');
    }
}
