<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\SystemSetting;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class SystemController extends Controller
{
    public function index(): View
    {
        // Get the authenticated user's company
        $company = Company::findOrFail(Auth::user()->company_id);

        // Get all users belonging to this company
        $users = User::where('company_id', $company->id)
            ->orderBy('name')
            ->paginate(10, ['*'], 'users_page');

        // Get system settings (create default if doesn't exist)
        $settings = SystemSetting::firstOrCreate(
            ['company_id' => $company->id],
            $this->defaultSettings($company)
        );

        return view('systems.index', [
            'company' => $company,
            'users' => $users,
            'settings' => $settings,
        ]);
    }
}
