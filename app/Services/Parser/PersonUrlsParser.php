<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Services\Parser;

use App\Services\Parser\Parser;

/**
 * Description of PersonUrlsParser
 *
 * @author KNovikov
 */
class PersonUrlsParser extends Parser
{

//    1. Список стран закодированных
//    2. Список урлов стран-актеров
//    3. Список урлов стран-режиссеров
//    4. 

    public function person()
    {
        $this->curlInit();
        $this->getOptions([]);
//        dd($this->user_agents);

        $this->getCountListsOfPerson();
        $this->getCountries();
    }

    public function getUrlsToParse()
    {
        $count_lists = $this->getCountListOfPerson();
        $urls = [];
        for ($i = 0; $i <= $count_lists; $i++) {
            
        }
    }

    public function getCountListsOfPerson()
    {
        $urls = $this->getUrlsToCountLists();

        foreach ($urls as $url) {
            $count_person = $this->getCountOfPerson($url);
            if ($count_person && $count_person > 100) {
                
            }
        }
//        $urls = $this->getUrlsToCountLists();
    }

    public function getCountOfPerson($url)
    {
        $str = 'Результаты поиска 4756)';
        preg_match('/\(([^()]*)\)/', $str, $matches);
        if (empty($matches)) {
            return false;
        }
        /* @var $count type int */
        $count = (int) $matches[1];
        return $count;
//        dd($matches);
        dd((int) $matches[1]);
        $this->getData($url, 'https://kinopoisk.ru/');
        $this->getXPath();
        $this->getElementsResult('.//title');
        preg_match('/\(([^()]*)\)/', $this->result, $matches);
        if (empty($matches)) {
            return false;
        }
        $count = (int) $matches[1];
        return $count;

//        dd($this->result);
//        dd(mb_convert_encoding($this->data, "UTF-8", 'Windows-1251'));
//        dd($this->data);
//        $data = $this->getParseResult($paths);
    }

    public function getUrlsToCountLists()
    {
        $encode_countries = $this->getCountries();
        $urls = [];
        foreach ($encode_countries as $country) {
            $urls[] = 'https://www.kinopoisk.ru/s/type/people/list/1/order/relevant/m_act[location]/' . $country . '/m_act[work]/actor/page/1/';
        }
//        dd($urls);
        return $urls;
    }

    public function getCountries()
    {
        $encode_countries = [];
        $countries = $this->fileToArray(__DIR__ . '/countries');
        foreach ($countries as $country) {
            $encode_countries[$country] = $this->urlencode($country);
        }
//        dd($encode_countries);
        return $encode_countries;
    }

}
