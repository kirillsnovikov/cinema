<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Type;

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
//        dd(Type::where('published', 1)->get());
        View::composer('layouts.header', function ($view) {
            $view->with('types', Type::where('published', 1)->get());
        });
    }

}
