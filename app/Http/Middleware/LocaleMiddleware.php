<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class LocaleMiddleware
{
    public function handle($request, Closure $next)
    {
        $user = Auth::user();
        $language = null;

        if ($user) {
            // Determine language safely
            if (is_array($user->settings)) {
                $language = $user->settings['language'] ?? null;
            } elseif (is_object($user->settings)) {
                $language = $user->settings->language ?? null;
            }
        } else {
        }

        // Set locale
        if ($language) {
            $locale = $language;
            App::setLocale($locale);
            Session::put('locale', $locale);
        } elseif (Session::has('locale')) {
            $locale = Session::get('locale');
            App::setLocale($locale);
        } else {
            $locale = config('app.locale');
            App::setLocale($locale);
        }

        return $next($request);
    }
}
