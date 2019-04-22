<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Services\Kinoparser;

use App\Contracts\Kinoparser\DataGetterInterface;

/**
 * Description of CurlKinopoiskDefault
 *
 * @author Кирилл
 */
class CurlKinopoiskDefault extends CurlDataGetter implements DataGetterInterface
{

    public function getData(string $url, string $referer = '', array $post_data = []): string
    {
        $this->getParameters();
    }

}
