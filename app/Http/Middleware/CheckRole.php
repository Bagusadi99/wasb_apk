<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    public function handle(Request $request, Closure $next, string $role)
    {
        if (!Auth::check() || Auth::user()->user_role !== $role) {
            return redirect()->route('login')->with('error', 'Anda tidak memiliki akses.');
        }

        return $next($request);
    }
}
