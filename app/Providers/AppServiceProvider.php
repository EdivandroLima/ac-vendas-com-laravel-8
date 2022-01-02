<?php

namespace App\Providers;

use App\Services\VendaService;
use Illuminate\Support\Facades\App;
use Illuminate\Pagination\Paginator;
use App\Repositories\VendaRepository;
use Illuminate\Support\ServiceProvider;
use App\Contracts\Services\VendaServiceInterface;
use App\Contracts\Repositories\VendaRepositoryInterface;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(VendaServiceInterface::class, VendaService::class);
        $this->app->bind(VendaRepositoryInterface::class, VendaRepository::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Paginator::useBootstrap();

        if (!App::environment('local')) {
            // URL::forceSchema('https');
            $this->app['request']->server->set('HTTPS', 'on');
        }
    }
}
