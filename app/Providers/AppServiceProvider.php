<?php

namespace App\Providers;

use App\Services\Tools\FileUploadService;
use App\Services\Tools\ResponseService;
use App\Services\Tools\TransactionService;
use App\Services\Tools\ValidationService;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(ResponseService::class);
        $this->app->singleton(ValidationService::class);

        $this->app->singleton(TransactionService::class, static fn($app): TransactionService => new TransactionService(
           responseService: $app->make(ResponseService::class),

        ));

          $this->app->singleton(FileUploadService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $enforceHttps = $this->app->environment('production');

        URL::forceRootUrl(config($enforceHttps));

        if ($enforceHttps) {
            $this->app->make('request')->server->set('HTTPS', 'on');
        }
    }
}
