<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Services\Kinoparser\Mock;

use App\Contracts\UrlGetterInterface;

/**
 * Description of UrlGetter
 *
 * @author KNovikov
 */
class UrlGetter implements UrlGetterInterface
{

    private $urls;

    public function __construct($urls)
    {
        
        $this->urls = $urls;
    }
    
    public function all()
    {
        return $this->urls;
    }
}
