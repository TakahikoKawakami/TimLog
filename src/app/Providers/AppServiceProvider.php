<?php

namespace App\Providers;

use App\Factories\TicketFactory;
use App\Repositories\TicketRepository;
use Illuminate\Support\ServiceProvider;
use App\Factories\TicketFactoryInterface;
use App\Factories\TicketDisplaySequenceFactory;
use App\Repositories\TicketRepositoryInterface;
use App\Repositories\TicketDisplaySequenceRepository;
use App\Factories\TicketDisplaySequenceFactoryInterface;
use App\Repositories\TicketDisplaySequenceRepositoryInterface;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $env = env('APP_ENV');
        switch ($env) {
            case ('production'):
                break;
            default:
                $this->app->bind('TicketService', 'App\Services\TicketService');
                $this->app->bind('TicketDisplaySequenceService', 'App\Services\TicketDisplaySequenceService');
                $this->app->bind('ResponseService', 'App\Services\ResponseService');
                $this->app->bind('TicketFactory', 'App\Factories\TicketFactory');
                $this->app->bind('TicketRepository', 'App\Repositories\TicketRepository');
                $this->app->bind('TicketDisplaySequenceFactory', 'App\Factories\TicketDisplaySequenceFactory');
                $this->app->bind('TicketDisplaySequenceRepository', 'App\Repositories\TicketDisplaySequenceRepository');
        }
        // $this->app->singleton(TicketFactoryInterface::class,function($app) {
        //     return new TicketFactory();
        //     //App\Repositories\TicketRepository::class
        // });
        // $this->app->singleton(TicketRepositoryInterface::class,function($app) {
        //         return new TicketRepository(new TicketFactory);
        //     //App\Repositories\TicketRepository::class
        // });
        // $this->app->singleton(TicketDisplaySequenceFactoryInterface::class,function($app) {
        //     return new TicketDisplaySequenceFactory();
        // });
        // $this->app->singleton(TicketDisplaySequenceRepositoryInterface::class,function($app) {
        //         return new TicketDisplaySequenceRepository(new TicketDisplaySequenceFactory);
        // });
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
