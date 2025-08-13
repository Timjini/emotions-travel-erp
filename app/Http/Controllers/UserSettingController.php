<?php

namespace App\Http\Controllers;

use App\Models\UserSetting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class UserSettingController extends Controller
{
    /**
     * Display a listing of user settings.
     */
    public function show(Request $request): View
    {
        $user = $request->user();
        abort_unless($user, 403, 'Unauthorized access');

        // Get existing settings or create with defaults
        $settings = $this->getOrCreateSettings($user);

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

        // Ensure user's current selections exist in available options
        if (! array_key_exists($settings->language, $languages)) {
            $settings->language = config('app.locale');
        }

        if (! in_array($settings->timezone, $timezones)) {
            $settings->timezone = config('app.timezone');
        }

        if (! array_key_exists($settings->theme, $themes)) {
            $settings->theme = 'system';
        }

        return view('user-settings.edit', [
            'settings' => $settings,
            'timezones' => $timezones,
            'languages' => $languages,
            'themes' => $themes,
        ]);
    }

    /**
     * Show settings form
     */
    public function edit(Request $request): View
    {
        $user = $request->user();
        abort_unless($user, 403, 'Unauthorized access');

        return view('user-settings.edit', [
            'settings' => $this->getOrCreateSettings($user),
            'timezones' => \DateTimeZone::listIdentifiers(),
            'languages' => [
                'en' => 'English',
                'pl' => 'Polski',
            ],
            'themes' => [
                'system' => 'System Default',
                'light' => 'Light Mode',
                'dark' => 'Dark Mode',
            ],
        ]);
    }

    /**
     * Update settings
     */
    public function update(Request $request): RedirectResponse
    {
        $user = $request->user();
        abort_unless($user, 403, 'Unauthorized access');

        // Get the user settings
        $settings = UserSetting::where('user_id', $user->id)->first();

        // Prepare the data to update/create
        $data = [
            'language' => $request->input('language'),
            'timezone' => $request->input('timezone'),
            'theme' => $request->input('theme'),
            'email_notifications' => $request->has('email_notifications'),
        ];

        if ($settings) {
            // Update existing settings
            $settings->update($data);
        } else {
            // Create new settings
            $data['user_id'] = $user->id;
            $settings = UserSetting::create($data);
        }

        // Debug output
        Log::debug('Updated settings:', $settings->toArray());

        // Apply theme preference immediately
        if ($data['theme'] !== 'system') {
            session(['theme' => $data['theme']]);
        } else {
            session()->forget('theme');
        }

        return back()->with('success', 'Settings updated!');
    }

    /**
     * Get or create user settings with defaults
     */
    private function getOrCreateSettings($user)
    {
        $defaults = [
            'language' => config('app.locale', 'en'),
            'timezone' => config('app.timezone', 'UTC'),
            'theme' => 'system',
            'email_notifications' => true,
        ];

        // First try to get existing settings
        $settings = UserSetting::where('user_id', $user->id)->first();

        // If settings exist but have null values, fill with defaults
        if ($settings) {
            foreach ($defaults as $key => $value) {
                if (is_null($settings->$key)) {
                    $settings->$key = $value;
                }
            }

            return $settings;
        }

        // Create new settings with defaults
        return UserSetting::create(array_merge(
            ['user_id' => $user->id],
            $defaults
        ));
    }
}
