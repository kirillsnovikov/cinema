<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Genre;

class BlogServiceProvider extends ServiceProvider
{

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->topMenu();
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    //Menu for users
    public function topMenu()
    {
        View::composer('layouts.header', function ($view) {
            $view->with('genres', Genre::where('parent_id', 0)->where('published', 1)->get());
        });
    }

}
