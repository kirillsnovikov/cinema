<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Helpers\ImageResizer;

class ImageServiceProvider extends ServiceProvider
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
        $this->app->bind('App\Helpers\Contracts\ImageInterface', function () {
            return new ImageResizer();
        });
    }

}
