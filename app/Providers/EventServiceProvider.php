<?php

namespace App\Providers;

use App\Models\File;
use App\Models\FileItem;
use App\Observers\FileObserver;
use App\Observers\FileItemObserver;
use Illuminate\Support\Facades\Log;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     */
    protected $listen = [
    ];

    /**
     * The subscriber classes for the application.
     */
    protected $subscribe = [
        \App\Listeners\LogProformaNotification::class,
    ];

    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
        parent::boot();

        // Model observers
        File::observe(FileObserver::class);
        Log::info('📦 FileObserver registered');

        FileItem::observe(FileItemObserver::class);
        Log::info('📦 FileItemObserver registered');
    }
}
