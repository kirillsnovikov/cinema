<?php

namespace App\Providers;

use App\Services\Di\Interfaces\FirstInterface;
use App\Services\Di\Interfaces\SecondInterface;
use App\Services\Di\MockFirstClass;
use App\Services\Di\MockSecondClass;
use Illuminate\Support\ServiceProvider;

class TestServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     * @return void
     */
    public function register()
    {
        $this->app->bind(FirstInterface::class, MockFirstClass::class);
        $this->app->bind(SecondInterface::class, MockSecondClass::class);
        
        $this->app->make(\App\Services\Di\HandlerClass::class);
//        dd($this->app->runningInConsole());
    }
    
    /**
     * Bootstrap services.
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
