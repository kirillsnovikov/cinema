<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\Image\ImageSave;

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
        $this->app->bind('App\Services\Image\Interfaces\ImageSaveInterface', function () {
            return new ImageSave();
        });
    }

}
