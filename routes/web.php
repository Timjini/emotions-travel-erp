<?php

use App\Http\Controllers\Company\SystemController;
use App\Http\Controllers\CRM\CustomerController;
use App\Http\Controllers\CRM\SupplierController;
use App\Http\Controllers\CurrencyController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DestinationController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\Payment\FileCostController;
use App\Http\Controllers\Payment\InvoiceController;
use App\Http\Controllers\Payment\ProformaController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProgramController;
use App\Http\Controllers\Report\ReportController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserSettingController;
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
    Route::prefix('profiles')->group(function () {
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

    Route::prefix('crm/suppliers')->controller(SupplierController::class)->group(function () {
        Route::get('/', 'index')->name('suppliers.index');
        Route::get('/create', 'create')->name('suppliers.create');
        Route::post('/', 'store')->name('suppliers.store');
        Route::get('/{supplier}', 'show')->name('suppliers.show');
        Route::get('/{supplier}/edit', 'edit')->name('suppliers.edit');
        Route::put('/{supplier}', 'update')->name('suppliers.update');
        Route::delete('/{supplier}', 'destroy')->name('suppliers.destroy');
    });

   Route::prefix('files')->group(function () {
    Route::get('/', [FileController::class, 'index'])->name('files.index');
    Route::get('/create', [FileController::class, 'create'])->name('files.create');
    Route::post('/store', [FileController::class, 'store'])->name('files.store');
    Route::post('/{file}/confirm', [FileController::class, 'confirm'])->name('files.confirm');
    Route::get('/{file}', [FileController::class, 'show'])->name('files.show');
    Route::get('/{file}/edit', [FileController::class, 'edit'])->name('files.edit');
    Route::patch('/{file}', [FileController::class, 'update'])->name('files.update');
    Route::delete('/{file}', [FileController::class, 'destroy'])->name('files.destroy');
    Route::get('/export', [FileController::class, 'index'])->name('files.export');
});


   Route::prefix('destinations')->group(function () {
    Route::get('/', [DestinationController::class, 'index'])->name('destinations.index');
    Route::get('/create', [DestinationController::class, 'create'])->name('destinations.create');
    Route::post('/store', [DestinationController::class, 'store'])->name('destinations.store');
    Route::get('/{destination}', [DestinationController::class, 'show'])->name('destinations.show');
    Route::get('/{destination}/edit', [DestinationController::class, 'edit'])->name('destinations.edit');
    Route::patch('/{destination}', [DestinationController::class, 'update'])->name('destinations.update');
    Route::delete('/{destination}', [DestinationController::class, 'destroy'])->name('destinations.destroy');
});


    Route::prefix('currencies')->group(function () {
        Route::get('/', [CurrencyController::class, 'index'])->name('currencies.index');
        Route::get('/create', [CurrencyController::class, 'create'])->name('currencies.create');
        Route::post('/store', [CurrencyController::class, 'store'])->name('currencies.store');
        Route::get('/{currency}', [CurrencyController::class, 'show'])->name('currencies.show');
        Route::get('/{currency}/edit', [CurrencyController::class, 'edit'])->name('currencies.edit');
        Route::patch('/{currency}', [CurrencyController::class, 'update'])->name('currencies.update');
        Route::delete('/{currency}', [CurrencyController::class, 'destroy'])->name('currencies.destroy');
    });

    Route::prefix('programs')->group(function () {
        Route::get('/', [ProgramController::class, 'index'])->name('programs.index');
        Route::get('/create', [ProgramController::class, 'create'])->name('programs.create');
        Route::post('/store', [ProgramController::class, 'store'])->name('programs.store');
        Route::get('/{program}', [ProgramController::class, 'show'])->name('programs.show');
        Route::get('/{program}/edit', [ProgramController::class, 'edit'])->name('programs.edit');
        Route::patch('/', [ProgramController::class, 'update'])->name('programs.update');
        Route::delete('/{program}', [ProgramController::class, 'destroy'])->name('programs.destroy');
    });

    Route::prefix('invoices')->group(function () {
        Route::get('/', [InvoiceController::class, 'index'])->name('invoices.index');
        Route::get('/{invoice}', [InvoiceController::class, 'show'])->name('invoices.show');
        Route::get('/create', [FileController::class, 'create'])->name('invoices.create');
        Route::get('/{invoice}/edit', [InvoiceController::class, 'edit'])->name('invoices.edit');
        Route::patch('/', [InvoiceController::class, 'update'])->name('invoices.update');
        Route::delete('/{invoice}', [InvoiceController::class, 'destroy'])->name('invoices.destroy');
    });

    Route::prefix('files/{file}')->group(function () {
        Route::get('/items', [FileController::class, 'showAddItems'])->name('files.items.add');
        Route::post('/items', [FileController::class, 'storeItem'])->name('files.items.store');
        Route::delete('/items/{item}', [FileController::class, 'destroyItem'])->name('files.items.destroy');
        Route::put('/items/{item}', [FileController::class, 'updateItem'])->name('files.items.update');
    });

    Route::prefix('/costs')->group(function () {
        Route::get('/', [FileCostController::class, 'index'])->name('files.costs.index');
        Route::get('/create', [FileCostController::class, 'create'])->name('file-costs.create');
        Route::patch('/', [FileCostController::class, 'update'])->name('file-costs.update');
        Route::get('/export', [FileCostController::class, 'export'])->name('files.costs.export');
        Route::post('/files/{file}/costs', [FileCostController::class, 'store'])->name('file-costs.store');
    });

    Route::post('/files/{file}/proformas', [ProformaController::class, 'store'])->name('proformas.store');
    Route::prefix('/proformas')->group(function () {
        Route::get('/', [ProformaController::class, 'index'])->name('proformas.index');
        Route::get('/{proforma}', [ProformaController::class, 'show'])->name('proformas.show');
        Route::get('/{proforma}/edit', [ProformaController::class, 'edit'])->name('proformas.edit');
        Route::delete('/{proforma}', [ProformaController::class, 'destroy'])->name('proformas.destroy');
        Route::patch('/{proforma}', [ProformaController::class, 'update'])->name('proformas.update');
        Route::post('/{proforma}/convert', [ProformaController::class, 'convertToInvoice'])->name('proformas.convert-to-invoice');
    });

    Route::get('invoices/{invoice}/download', [InvoiceController::class, 'downloadPdf'])->name('invoices.download.pdf');

    Route::prefix('/company')->group(function () {
        Route::get('/system', [SystemController::class, 'index'])->name('company.system.index');
        Route::get('/system/company/edit', [SystemController::class, 'editCompany'])->name('company.system.edit-company');
        Route::put('/system/company/update', [SystemController::class, 'updateCompany'])->name('company.system.update-company');
        Route::get('/system/settings/edit', [SystemController::class, 'editSettings'])->name('company.system.edit-settings');
        Route::put('/system/settings/update', [SystemController::class, 'updateSettings'])->name('company.system.update-settings');
        Route::get('/system/create', [SystemController::class, 'createCompany'])->name('company.system.create');
        Route::post('/system/store', [SystemController::class, 'storeCompany'])->name('company.system.store');
        Route::post('/temporary', [SystemController::class, 'createTemporary'])->name('company.system.create-temporary');
    });

     Route::prefix('reports')->group(function () {
        Route::get('/', [ReportController::class, 'index'])->name('reports.index');
        Route::post('/', [ReportController::class, 'generate'])->name('reports.generate');
     });
});

require __DIR__.'/auth.php';
