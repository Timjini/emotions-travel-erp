<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Models\Customer;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'customers' => Customer::count(),
            'users' => User::count(),
            'recent_customers' => Customer::latest()->take(5)->get(),
            'active_users' => User::where('last_active_at', '>=', now()->subDays(30))->count()
        ];

        return view('dashboard', compact('stats'));
    }
}