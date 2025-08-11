<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserSettingController;
use App\Http\Controllers\CRM\CustomerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FileController;
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
        Route::get('/', [ProfileController::class, 'edit'])->name('profiles.edit');
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

     Route::prefix('files')->group(function () {
        Route::get('/', [FileController::class, 'index'])->name('files.index');
        Route::get('/create', [FileController::class, 'create'])->name('files.create');
        Route::post('/store', [FileController::class, 'store'])->name('files.store');
        Route::post('/{file}/confirm', [FileController::class, 'confirm'])->name('files.confirm');
        Route::get('/{file}', [FileController::class, 'show'])->name('files.show');
        Route::get('/{file}/edit', [FileController::class, 'edit'])->name('files.edit');
        Route::patch('/', [FileController::class, 'update'])->name('files.update');
        Route::delete('/', [FileController::class, 'destroy'])->name('files.destroy');
    });

     Route::prefix('invoices')->group(function () {
        Route::get('/', [FileController::class, 'index'])->name('files.index');
        Route::get('/create', [FileController::class, 'create'])->name('invoices.create');
    });

    Route::prefix('files/{file}')->group(function () {
        Route::get('/items', [FileController::class, 'showAddItems'])->name('files.items.add');
        Route::post('/items', [FileController::class, 'storeItem'])->name('files.items.store');
        Route::delete('/items/{item}', [FileController::class, 'destroyItem'])->name('files.items.destroy');
    });

});

require __DIR__.'/auth.php';
