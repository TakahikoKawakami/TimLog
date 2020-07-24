<?php

namespace App\Providers;

use App\Factories\TicketFactory;
use App\Repositories\TicketRepository;
use Illuminate\Support\ServiceProvider;
use App\Factories\TicketFactoryInterface;
use App\Repositories\TicketRepositoryInterface;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(TicketFactoryInterface::class,function($app) {
            return new TicketFactory();
            //App\Repositories\TicketRepository::class
        });
        $this->app->singleton(TicketRepositoryInterface::class,function($app) {
                return new TicketRepository(new TicketFactory);
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
        /* for gitpod
        we’ll need to following code in our AppServiceProvider to force Laravel to use our APP_URL to generate URLs and Routes.
        The code we’ve added forces Laravel to use the app.url config entry (which is gotten from .env’s APP_URL) as the root URL.
        */
        \URL::forceRootUrl(\Config::get('app.url'));
        if (\Str::contains(\Config::get('app.url'), 'https://')) {
            \URL::forceScheme('https');
        }
    }
}
