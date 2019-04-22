<?php

namespace App\Providers;

use App\Contracts\Kinoparser\DataGetterInterface;
use App\Contracts\Kinoparser\ParserInterface;
use App\Contracts\Kinoparser\UrlsGetterInterface;
use App\Services\Kinoparser\CurlKinopoiskDefault;
use App\Services\Kinoparser\DataParser;
use App\Services\Kinoparser\PersonUrls;
use App\Services\Kinoparser\PersonUrlsGetter;
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
        $this->app->bind(ParserInterface::class, DataParser::class);
        $this->app->when(PersonUrls::class)->needs(UrlsGetterInterface::class)->give(PersonUrlsGetter::class);
        $this->app->bind(DataGetterInterface::class, CurlKinopoiskDefault::class);
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
