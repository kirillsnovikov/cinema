<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\Parser\Parser;

class ParserServiceProvider extends ServiceProvider
{

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('App\Services\Parser\Interfaces\ParserInterface', function () {
            return new Parser();
        });
    }

}
