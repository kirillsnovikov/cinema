<?php

namespace App\Providers;

use App\Contracts\Kinoparser\UrlGetterInterface;
use App\Services\Kinoparser\PersonUrlGetter;
use App\Services\Kinoparser\PersonUrls;
use Illuminate\Support\ServiceProvider;

class KinoparserServiceProvider extends ServiceProvider
{

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
//        $this->app->bind(\App\Contracts\Kinoparser\UrlGetterInterface::class, \App\Services\Kinoparser\UrlGetter::class);
        $this->app->when(PersonUrls::class)->needs(UrlGetterInterface::class)->give(PersonUrlGetter::class);
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

}
