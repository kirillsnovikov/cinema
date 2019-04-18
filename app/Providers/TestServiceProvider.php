<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class TestServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(\App\Services\Di\Interfaces\FirstInterface::class, \App\Services\Di\MockFirstClass::class);
        $this->app->bind(\App\Services\Di\Interfaces\SecondInterface::class, \App\Services\Di\MockSecondClass::class);
        $this->app->bind(\App\Services\Di\Interfaces\SecondInterface::class, \App\Services\Di\MockSecondClass::class);
        $this->app->bind(\App\Services\Di\Interfaces\SecondInterface::class, \App\Services\Di\MockSecondClass::class);
        $this->app->bind(\App\Services\Di\Interfaces\SecondInterface::class, \App\Services\Di\MockSecondClass::class);
        $this->app->bind(\App\Services\Di\Interfaces\SecondInterface::class, \App\Services\Di\MockSecondClass::class);
        $this->app->bind(\App\Services\Di\Interfaces\SecondInterface::class, \App\Services\Di\MockSecondClass::class);
        
        $this->app->make(\App\Services\Di\HandlerClass::class);
//        dd($this->app->runningInConsole());
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
    
//    public $singletons = [
//        \App\Services\Di\Interfaces\FirstInterface::class => \App\Services\Di\FirstClass::class
//    ];
}
