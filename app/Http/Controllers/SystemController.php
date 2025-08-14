<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Setting;
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
        $settings = Setting::firstOrCreate(
            ['company_id' => $company->id],
            $this->defaultSettings($company)
        );

        return view('systems.index', [
            'company' => $company,
            'users' => $users,
            'settings' => $settings,
        ]);
    }

    /**
     * Default system settings for new companies
     */
    protected function defaultSettings(Company $company): array
    {
        return [
            'company_id' => $company->id,
            'invoice_prefix' => 'INV-',
            'invoice_start_number' => 1,
            'default_currency' => 'USD',
            'default_language' => 'en',
            'timezone' => 'UTC',
            'date_format' => 'Y-m-d',
            'financial_year_start' => '01-01',
        ];
    }
}
