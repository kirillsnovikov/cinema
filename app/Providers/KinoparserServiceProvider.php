<?php

namespace App\Providers;

use App\Contracts\Kinoparser\DataGetterInterface;
use App\Contracts\Kinoparser\ParserInterface;
use App\Contracts\Kinoparser\UrlsGetterInterface;
use App\Services\Kinoparser\Data\ElementaryDataGetter;
use App\Services\Kinoparser\Data\KinopoiskDataGetter;
use App\Services\Kinoparser\Data\Layouts\CurlKinopoiskDefault;
use App\Services\Kinoparser\Data\Layouts\ElementaryGetContent;
use App\Services\Kinoparser\Parser\XpathParser;
use App\Services\Kinoparser\Urls\Layouts\HandlerPersonUrls;
use App\Services\Kinoparser\Urls\PersonUrlsGetter;
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
        $this->app->bind(ParserInterface::class, XpathParser::class);
        $this->app->when(PersonUrlsGetter::class)->needs(UrlsGetterInterface::class)->give(HandlerPersonUrls::class);
        $this->app->when(KinopoiskDataGetter::class)->needs(DataGetterInterface::class)->give(CurlKinopoiskDefault::class);
        $this->app->when(ElementaryDataGetter::class)->needs(DataGetterInterface::class)->give(ElementaryGetContent::class);
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
