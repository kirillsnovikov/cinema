<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Services\Kinoparser;

use App\Contracts\Kinoparser\UrlsGetterInterface;

/**
 * Description of Urls
 *
 * @author KNovikov
 */
abstract class Urls
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
        return $this->urls->all();
    }
}
