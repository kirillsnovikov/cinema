<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Services\Kinoparser\Urls\Layouts;

/**
 * Description of PersonUrlsGetterFromFile
 *
 * @author KNovikov
 */
class PersonUrlsGetterFromFile
{

    /**
     * 
     * @return array
     */
    public function getUrls(): array
    {
        return ['https://www.kinopoisk.ru/name/5623378/'];
        $file = __DIR__ . '/../../config/person_urls.txt';
        if (realpath($file)) {
            $urls = array_unique(file($file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES), SORT_STRING);
//            asort($urls, SORT_STRING | SORT_FLAG_CASE | SORT_NATURAL);
            natsort($urls);
            return $urls;
        }
    }

}
