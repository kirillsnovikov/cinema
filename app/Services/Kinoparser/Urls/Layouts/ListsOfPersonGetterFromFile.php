<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Services\Kinoparser\Urls\Layouts;

/**
 * Description of ListsOfPersonGetterFromFile
 *
 * @author KNovikov
 */
class ListsOfPersonGetterFromFile
{

    public function getUrlsLists(): array
    {
        $file = __DIR__ . '/../../config/person_urls_lists.txt';
        if (realpath($file)) {
//            $lists = file($file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
            $lists = array_unique(file($file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES), SORT_STRING);
//            dd($lists);
//            dd(count($lists));
            return $lists;
        }
        return [];
    }

}
