<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class LanguageController extends Controller
{
    public function switch(Request $request)
    {
        $locale = $request->input('locale', 'en');
        
        if (!in_array($locale, ['en', 'ar'])) {
            $locale = 'en';
        }

        app()->setLocale($locale);
        session(['locale' => $locale]);
        session(['rtl' => $locale === 'ar']);

        return redirect()->back();
    }

    public function setLocale(string $locale)
    {
        if (!in_array($locale, ['en', 'ar'])) {
            $locale = 'en';
        }

        app()->setLocale($locale);
        session(['locale' => $locale]);
        session(['rtl' => $locale === 'ar']);

        return redirect()->back();
    }
}
