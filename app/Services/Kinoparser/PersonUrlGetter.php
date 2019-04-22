<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Services\Kinoparser;

use App\Contracts\Kinoparser\UrlGetterInterface;

/**
 * Description of PersonUrlGetter
 *
 * @author KNovikov
 */
class PersonUrlGetter implements UrlGetterInterface
{
    
    public function all(): array
    {
        return ['1', '2', 'v'];
    }

}
