<?php 
use App\Models\File;
use App\Models\FileItem;
use App\Observers\FileObserver;
use App\Observers\FileItemObserver;
use Illuminate\Support\Facades\Log;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;


class EventServiceProvider extends ServiceProvider
{
    public function boot()
    {
        Log::info('📦 FileObserver registered');
        File::observe(FileObserver::class);
        // FileItem::observe(FileItemObserver::class);
    }
}