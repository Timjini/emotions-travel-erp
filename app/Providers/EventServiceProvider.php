<?php

namespace App\Providers;
;
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
        \App\Models\FileItem::observe(\App\Observers\FileItemObserver::class);

    }
}
