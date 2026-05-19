<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleRedirect
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    // public function handle(Request $request, Closure $next): Response
    // {
    //     return $next($request);
    // }
    public function handle($request, Closure $next)
{
    $user = auth()->user();

    if ($user->hasRole('superadmin')) {
        return redirect('/superadmin/dashboard');
    }

    if ($user->hasRole('admin')) {
        return redirect('/admin/dashboard');
    }

    if ($user->hasRole('teamleader')) {
        return redirect('/team/dashboard');
    }

    if ($user->hasRole('support_agent')) {
        return redirect('/agent/dashboard');
    }

    return redirect('/customer/dashboard');
}
}
