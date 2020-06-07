<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\TicketRepositoryInterface;
use App\Repositories\TicketRepository;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(TicketRepositoryInterface::class,function($app) {
                return new TicketRepository();
            //App\Repositories\TicketRepository::class
            });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
