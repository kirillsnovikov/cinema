<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Services\Kinoparser\Options;

use App\Contracts\Kinoparser\ReferersGetterInterface;
use App\Services\Kinoparser\Curl\BaseCurl;

/**
 * Description of ReferersGetter
 *
 * @author Кирилл
 */
class ReferersGetter implements ReferersGetterInterface
{

    /**
     * 
     * @return string
     */
    public function getReferers(): string
    {
        if (realpath(BaseCurl::REFERERS_FILE)) {
            $referers = file(BaseCurl::REFERERS_FILE, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

            if (!empty($referers)) {
                return $referers[mt_rand(0, count($referers) - 1)];
            }
        }
        return 'https://ya.ru/';
    }

}
