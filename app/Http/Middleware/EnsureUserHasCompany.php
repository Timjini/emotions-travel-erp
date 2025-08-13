<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class EnsureUserHasCompany
{
    public function handle($request, Closure $next)
    {
        if (Auth::check() && is_null(Auth::user()->company_id)) {
            return redirect()->route('company.system.create')
                ->with('error', 'Please create a company before continuing.');
        }

        return $next($request);
    }
}
