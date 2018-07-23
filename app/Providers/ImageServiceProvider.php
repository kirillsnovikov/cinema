<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\Image\ImageResizer;
use App\Services\Image\SaveImage;

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
        $this->app->bind('App\Services\Interfaces\ImageInterface', function () {
            return new ImageResizer();
        });
    }

}
