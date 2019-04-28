<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Services\Kinoparser\Options;

use App\Contracts\Kinoparser\ReferersGetterInterface;

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
        $file = __DIR__ . '/../config/referers.txt';
        if (realpath($file)) {
            $referers = file($file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

            if (!empty($referers)) {
                return $referers[mt_rand(0, count($referers) - 1)];
            }
        }
        return 'https://ya.ru/';
    }

}
