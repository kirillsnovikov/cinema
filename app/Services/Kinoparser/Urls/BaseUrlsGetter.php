<?php

namespace App\Services\Kinoparser\Urls;

use App\Contracts\Kinoparser\UrlsGetterInterface;

/**
 * Description of BaseUrlsGetter
 *
 * @author KNovikov
 */
abstract class BaseUrlsGetter
{

    /**
     * @var UrlGetterInterface
     */
    private $urls;

    public function __construct(UrlsGetterInterface $urls)
    {

        $this->urls = $urls;
    }

    public function getAll()
    {
        return $this->urls->getAll();
    }

}
