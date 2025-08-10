<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserSettingController;
use App\Http\Controllers\CRM\CustomerController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

// Language switcher route
Route::redirect('/', '/login');

Route::get('lang/{locale}', function ($locale) {
    $availableLocales = ['en', 'pl'];

    if (in_array($locale, $availableLocales)) {
        session(['locale' => $locale]);
    }

    return redirect()->back();
})->name('lang.switch');
// Route::get('/', function () {
//      return view('dashboard');
// });

Route::middleware(['auth', 'verified'])->group(function () {

    // DashboardController
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Profile routes
    Route::prefix('profile')->group(function () {
        Route::get('/', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/', [ProfileController::class, 'destroy'])->name('profile.destroy');
    });

    // User management
    Route::prefix('users')->controller(UserController::class)->group(function () {
        Route::get('/', 'index')->name('users.index');
        Route::get('/create', 'create')->name('users.create');
        Route::post('/', 'store')->name('users.store');
        Route::get('/{user}', 'show')->name('users.show');
        Route::get('/{user}/edit', 'edit')->name('users.edit');
        Route::patch('/{user}', 'update')->name('users.update');
        Route::delete('/{user}', 'destroy')->name('users.destroy');
    });

    // // Settings
    Route::prefix('user-settings')->controller(UserSettingController::class)->group(function () {
        Route::get('/', 'show')->name('user-settings.show');
        // Route::get('/edit', 'edit')->name('user-settings.edit');
        Route::put('/', 'update')->name('user-settings.update');
    });
     // CRM Customers
    Route::prefix('crm/customers')->controller(CustomerController::class)->group(function () {
        Route::get('/', 'index')->name('customers.index');
        Route::get('/create', 'create')->name('customers.create');
        Route::post('/', 'store')->name('customers.store');
        Route::get('/{customer}', 'show')->name('customers.show');
        Route::get('/{customer}/edit', 'edit')->name('customers.edit');
        Route::put('/{customer}', 'update')->name('customers.update');
        Route::delete('/{customer}', 'destroy')->name('customers.destroy');
    });

    // Add other authenticated routes here...
});

require __DIR__.'/auth.php';
