<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class LanguageMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if locale is set in session
        if (session()->has('locale')) {
            app()->setLocale(session('locale'));
        }
        // Check URL for locale
        elseif ($request->segment(1) && in_array($request->segment(1), ['en', 'ar'])) {
            app()->setLocale($request->segment(1));
            session(['locale' => $request->segment(1)]);
        }
        // Check browser preference
        elseif ($request->header('Accept-Language')) {
            $locale = substr($request->header('Accept-Language'), 0, 2);
            if (in_array($locale, ['en', 'ar'])) {
                app()->setLocale($locale);
            }
        }

        // Set RTL for Arabic
        if (app()->getLocale() === 'ar') {
            session(['rtl' => true]);
        } else {
            session(['rtl' => false]);
        }

        return $next($request);
    }
}
