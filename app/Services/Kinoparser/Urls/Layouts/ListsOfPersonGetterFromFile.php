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

    /**
     * 
     * @return array
     */
    public function getUrlsLists(): array
    {
        $file = ListsOfPersonGetter::PERSON_URLS_LISTS;
        if (realpath($file)) {
            $lists = array_unique(file($file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES), SORT_STRING);
            return $lists;
        }
    }

}
