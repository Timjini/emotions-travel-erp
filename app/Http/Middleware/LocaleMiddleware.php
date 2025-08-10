<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class LocaleMiddleware
{
    public function handle($request, Closure $next)
    {
        if (Auth::check()) {
            Log::info('User is authenticated in LocaleMiddleware.', [
                'user_id' => Auth::id(),
                'language' => optional(Auth::user()->settings)->language,
            ]);
        } else {
            Log::info('User is NOT authenticated in LocaleMiddleware.');
        }

        if (Auth::check() && optional(Auth::user()->settings)->language) {
            $locale = Auth::user()->settings->language;
            App::setLocale($locale);
            Session::put('locale', $locale);
            Log::info('Locale set from userSetting.', ['locale' => $locale]);
        } elseif (Session::has('locale')) {
            $locale = Session::get('locale');
            App::setLocale($locale);
            Log::info('Locale set from session.', ['locale' => $locale]);
        } else {
            $locale = config('app.locale');
            App::setLocale($locale);
            Log::info('Locale set from app default.', ['locale' => $locale]);
        }

        return $next($request);
    }
}
