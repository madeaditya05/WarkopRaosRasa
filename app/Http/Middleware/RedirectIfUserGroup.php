<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfUserGroup
{
    public function handle($request, Closure $next)
    {
        $user = Auth::user();

        if ($user->user_group === 'admin') {
            return redirect('/admin/dashboard'); // Sesuaikan URL
        }

        if ($user->user_group === 'customer') {
            return redirect('/customer/home'); // Sesuaikan URL
        }

        return $next($request);
    }
}

