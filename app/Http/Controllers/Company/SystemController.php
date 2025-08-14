<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\Currency;
use App\Models\Destination;
use App\Models\Setting;
use App\Models\User;
use App\Services\FileUploadService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class SystemController extends Controller
{
    /**
     * Display the system dashboard with company info, users, and settings
     */
    public function index(): View
    {
        $user = Auth::user();

        $company = $user->company_id ? Company::find($user->company_id) : null;

        if ($company) {
            // Only load users and settings if company exists
            $users = User::where('company_id', $company->id)
                ->orderBy('name')
                ->paginate(10, ['*'], 'users_page');

            $settings = Setting::firstOrCreate(
                ['company_id' => $company->id],
                $this->defaultSettings($company)
            );
        } else {
            // No company yet — return empty/default values
            $users = collect();  // empty collection
            $settings = null;
        }

        return view('company.system.index', [
            'company' => $company,
            'users' => $users,
            'settings' => $settings,
        ]);
    }

    /**
     * Show the form for editing company information
     */
    public function editCompany(): View
    {
        $company = Company::findOrFail(Auth::user()->company_id);

        return view('company.system.edit-company', compact('company'));
    }

    /**
     * Update the company information
     */
    public function updateCompany(Request $request): RedirectResponse
    {
        $company = Company::findOrFail(Auth::user()->company_id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'legal_name' => 'nullable|string|max:255',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'email' => 'required|email',
            'phone_1' => 'required|string|max:20',
            'website' => 'nullable|url',
            'address' => 'required|string',
            'city' => 'required|string',
            'state' => 'nullable|string',
            'post_code' => 'required|string',
            'country' => 'required|string',
            'vat_number' => 'required|string',
        ]);

        $fileUploadService = new FileUploadService;

        // Handle logo upload
        if ($request->hasFile('logo')) {

            // Delete old logo if exists
            if ($company->logo_path) {
                $fileUploadService->deleteLogo($company->logo_path);
            }

            // Upload new logo
            $path = $fileUploadService->uploadLogo($request->file('logo'));

            if ($path) {
                $company->logo_path = $path;
            } else {

                return back()->with('error', 'Logo upload failed');
            }
        }

        $company->update($validated);

        return redirect()->route('company.system.index')
            ->with('success', 'Company information updated successfully.');
    }

    /**
     * Show the form for editing system settings
     */
    public function editSettings(): View
    {
        $company = Company::findOrFail(Auth::user()->company_id);
        $settings = Setting::firstOrCreate(
            ['company_id' => $company->id],
            $this->defaultSettings($company)
        );

        return view('company.system.edit-settings', compact('settings'));
    }

    /**
     * Update the system settings
     */
    public function updateSettings(Request $request): RedirectResponse
    {
        $company = Company::findOrFail(Auth::user()->company_id);
        $settings = Setting::firstOrCreate(
            ['company_id' => $company->id],
            $this->defaultSettings($company)
        );

        $validated = $request->validate([
            'invoice_prefix' => 'required|string|max:10',
            'invoice_start_number' => 'required|integer|min:1',
            'default_currency' => 'required|string|size:3',
            'default_language' => 'required|string|size:2',
            'timezone' => 'required|timezone',
            'date_format' => 'required|string',
            'financial_year_start' => 'required|date_format:m-d',
        ]);

        $settings->update($validated);

        return redirect()->route('company.system.index')
            ->with('success', 'System settings updated successfully.');
    }

    public function createCompany()
    {

        // Available options with user's current selection prioritized
        $timezones = \DateTimeZone::listIdentifiers();
        $languages = [
            'en' => 'English',
            'pl' => 'Polski',
        ];
        $themes = [
            'system' => 'System Default',
            'light' => 'Light Mode',
            'dark' => 'Dark Mode',
        ];

        return view('company.system.create', [
            'timezones' => $timezones,
            'languages' => $languages,
            'themes' => $themes,
        ]);
    }

    public function storeCompany(Request $request)
    {
        $validated = $request->validate([
            // Basic Information
            'name' => 'required|string|max:255',
            'legal_name' => 'nullable|string|max:255',
            'type' => 'required|string|in:agency,dmo,hotel,tour_operator,other',
            'logo_path' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'invoicing_entity' => 'nullable|string|max:255',

            // Contact Information
            'email' => 'nullable|email|max:255',
            'contact_person' => 'nullable|string|max:255',
            'website' => 'nullable|url|max:255',
            'phone_1' => 'nullable|string|max:50',
            'phone_2' => 'nullable|string|max:50',

            // Address Information
            'address' => 'required|string|max:255',
            'post_code' => 'required|string|max:20',
            'city' => 'required|string|max:100',
            'district' => 'nullable|string|max:100',
            'country' => 'required|string|max:100',

            // Business Information
            'vat_number' => 'nullable|string|max:50',

            // Financial Information
            'iban' => 'nullable|string|max:34',
            'swift_code' => 'nullable|string|max:11',

            // Additional Fields
            'status' => 'required|string|in:active,inactive,suspended',
            'preferred_language' => 'nullable|string|in:en,es,fr,de,it',
            'notes' => 'nullable|string',
            'source' => 'nullable|string|max:255',
        ]);

        try {
            // Handle file upload
            $path = null;
            if ($request->hasFile('logo_path')) {
                $fileUploadService = new FileUploadService;
                $path = $fileUploadService->uploadLogo($request->file('logo_path'));
            }
            // Save company
            $company = Company::create([
                ...$validated,
                'logo_path' => $path,
            ]);

            // Assign company to current user
            $user = User::find(Auth::user()->id);
            $user->company_id = $company->id;
            $user->save();

            return redirect()->route('company.system.index')
                ->with('success', 'Company created successfully!');
        } catch (\Exception $e) {
            Log::error('Company creation failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return back()->withInput()
                ->with('error', 'Company creation failed. Please try again.');
        }
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

    public function createTemporary(Request $request)
    {
        try {
            $userId = Auth::id();

            // Get default values from .env or use fallbacks
            $defaultEmail = env('DEFAULT_COMPANY_EMAIL', 'temp-company@example.com');
            $defaultCountry = env('DEFAULT_COMPANY_COUNTRY', 'United States');
            $defaultCity = env('DEFAULT_COMPANY_CITY', 'New York');
            $defaultCurrencyCode = env('DEFAULT_CURRENCY_CODE', 'USD');
            $defaultCurrencyName = env('DEFAULT_CURRENCY_NAME', 'US Dollar');

            // Create temporary company
            $company = Company::create([
                'name' => 'Temporary Company for User #' . $userId,
                'legal_name' => 'Temporary Company',
                'type' => 'other',
                'logo_path' => null,
                'email' => $defaultEmail,
                'address' => 'Temporary Address',
                'post_code' => '00000',
                'city' => $defaultCity,
                'country' => $defaultCountry,
                'status' => 'active',
                'created_by' => $userId,
                'is_temporary' => true,
            ]);

            // Assign company to user
            $user = User::find($userId);
            $user->company_id = $company->id;
            $user->save();

            // Create default currency for this company
            $currency = Currency::create([
                'name' => $defaultCurrencyName,
                'code' => $defaultCurrencyCode,
                'symbol' => '$', // optional
                'company_id' => $company->id,
                'created_by' => $userId,
                'is_active' => true,
            ]);

            // Create default destination for this company
            Destination::create([
                'name' => 'Default Destination',
                'city' => $defaultCity,
                'country' => $defaultCountry,
                'currency_id' => $currency->id,
                'company_id' => $company->id,
                'created_by' => $userId,
                'is_active' => true,
            ]);

            return redirect()->route('dashboard')->with('success', 'Temporary company created with default currency and destination.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to create temporary company: ' . $e->getMessage());
        }
    }
}
