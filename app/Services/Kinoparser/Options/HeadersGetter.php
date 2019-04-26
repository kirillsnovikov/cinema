<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Services\Kinoparser\Options;

use App\Contracts\Kinoparser\HeadersGetterInterface;

/**
 * Description of HeadersGetter
 *
 * @author KNovikov
 */
class HeadersGetter implements HeadersGetterInterface
{

    public function getHeaders(): array
    {
        $headers = [
//            'Accept: text/xml,application/xml,application/xhtml+xml,text/html;q=0.9,text/plain;q=0.8,image/png,*/*;q=0.5',
//            'Cache-Control: max-age=100',
//            'Content-Type: application/x-www-form-urlencoded; charset=UTF-8',
//            'X-DevTools-Emulate-Network-Conditions-Client-Id: A906F88D7D0FEF7CDF69F949F40CCEAA',
//            'Connection: keep-alive',
//            'Keep-Alive: 300',
//            'Accept-Charset: ISO-8859-1,utf-8;q=0.7,*;q=0.7',
//            'X-Requested-With: XMLHttpRequest',
//            'X-CSRF-Token: 4lF6LGd9-dj_Iwqbgd459dQBkPV6qEFbLHW8'
            'Accept: text/xml,application/xml,application/xhtml+xml,text/html;q=0.9,text/plain;q=0.8,image/png,*/*;q=0.5',
            'Accept-Language: ru-RU,ru;q=0.9,en-US;q=0.8,en;q=0.7',
            'Cache-Control: max-age=100',
            'Connection: keep-alive',
            'Content-Type: application/json',
            'Keep-Alive: 300',
            'Accept-Charset: ISO-8859-1,utf-8;q=0.7,*;q=0.7',
            'X-Requested-With: XMLHttpRequest'
        ];

        return $headers;
    }

}
