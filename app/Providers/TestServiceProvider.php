<?php

namespace App\Providers;

use App\Services\Di\Interfaces\SecondInterface;
use App\Services\Di\Interfaces\UrlGetterInterface;
use App\Services\Di\MockSecondClass;
use App\Services\Di\MockUrlGetterClass;
use Illuminate\Support\ServiceProvider;

class TestServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     * @return void
     */
    public function register()
    {
        $this->app->bind(UrlGetterInterface::class, MockUrlGetterClass::class);
        $this->app->bind(SecondInterface::class, MockSecondClass::class);
        
//        $this->app->make(HandlerClass::class);
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
//        \App\Services\Di\Interfaces\UrlGetterInterface::class => \App\Services\Di\UrlGetterClass::class
//    ];
}
