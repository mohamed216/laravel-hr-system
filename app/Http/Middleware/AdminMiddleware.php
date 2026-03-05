<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check()) {
            return redirect('/login');
        }

        $user = Auth::user();

        if (!$user->isAdmin() && !$user->isHR()) {
            return redirect('/dashboard')->with('error', __('You do not have permission to access this page'));
        }

        return $next($request);
    }
}
