<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Services\Kinoparser;

use App\Contracts\Kinoparser\UrlGetterInterface;
use App\Services\Kinoparser\PersonUrlGetter;

/**
 * Description of UrlGetter
 *
 * @author KNovikov
 */
abstract class UrlGetter
{

    /**
     * @var UrlSetter
     */
    private $urls;

    public function __construct(UrlSetter $urls)
    {
        
        $this->urls = $urls;
    }
}
