<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Services\Di;

use App\Services\Di\Interfaces\UrlGetterInterface;

/**
 * Description of UrlGetterClass
 * @author KNovikov
 */
class UrlGetterClass implements UrlGetterInterface
{
    /**
     * @return array
     */
    public function getUrls(): array
    {
        //dd(42);
        return [];
    }

}
