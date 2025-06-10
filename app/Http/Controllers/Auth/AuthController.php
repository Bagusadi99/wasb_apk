<?php
namespace App\Http\Controllers\Auth;
use App\Http\Controllers\Controller;

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

    public function login(Request $request)
    {
        $request->validate([
            'user_nama'     => 'required',
            'user_password' => 'required'
        ]);

        $user = User::where('user_nama', $request->user_nama)->first();

        if ($user && Hash::check($request->user_password, $user->user_password)) {
            // Hanya user dengan role 'admin' atau 'petugas' yang boleh login
            if ($user->user_role === 'admin') {
                Auth::login($user);
                return redirect()->route('admin.dashadmin');
            } elseif ($user->user_role === 'petugas') {
                Auth::login($user);
                return redirect()->route('user.homeuser');
            } else {
                return back()->with('error', ' Anda tidak memiliki akses ke sistem.');
            }
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
