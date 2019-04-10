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
        $options = [
            'use_proxy' => 'socks4',
            'use_user_agents' => true,
            'socks5' => 1
        ];
        dd(microtime(TRUE));
        $this->curlInit();
        $this->getOptions($options);
        $this->putUrlsToFile();
        $this->curlClose();
        fclose($this->logs);
        
        return redirect()
                        ->route('admin.parser.index')
                        ->with('success', 'Парсинг успешно завершен!');
    }

    public function putUrlsToFile()
    {
        $urls = $this->getUrlsListsOfPerson();
        $fp = fopen(__DIR__ . '/director_urls_2', 'wb');
        foreach ($urls as $url) {
            fwrite($fp, $url . PHP_EOL);
        }
        fclose($fp);
    }

    public function getUrlsListsOfPerson()
    {
        $country_person_count = $this->getCountOfPerson();
        $count_person_list = [];
        $urls = [];
        foreach ($country_person_count as $encode_country => $person_count) {
            $count_list = ceil($person_count / 100);
            for ($i = 1; $i <= $count_list; $i++) {
                $url = 'https://www.kinopoisk.ru/s/type/people/list/1/order/relevant/m_act[location]/' . $encode_country . '/m_act[work]/director/page/' . $i . '/';
                $urls[] = $url;
            }
            $count_person_list[$encode_country] = $count_list;
        }
        return $urls;
    }

    public function getCountOfPerson()
    {
        $urls = $this->getUrlsToCountLists();
        $country_person_count = [];
        $i = 1;

        foreach ($urls as $encode_country => $url) {
            fwrite($this->logs, $encode_country . PHP_EOL . $i . ' from ' . count($urls) . PHP_EOL);
            $this->getData($url, 'https://kinopoisk.ru/');
            $this->getXPath();
            $this->getElementsResult('.//title');
//            dd($this->result);
            if (preg_match('/\(([^()]*)\)/', $this->result[0], $matches)) {
                $person_count = $matches[1];
                fwrite($this->logs, 'Кол-во персон: ' . $person_count . PHP_EOL);
                $country_person_count[$encode_country] = $person_count;
            }
            $i++;
        }

        return $country_person_count;
    }

    public function getUrlsToCountLists()
    {
        $encode_countries = $this->getCountries();
        $urls = [];
        foreach ($encode_countries as $encode_country) {
            $urls[$encode_country] = 'https://www.kinopoisk.ru/s/type/people/list/1/order/relevant/m_act[location]/' . $encode_country . '/m_act[work]/director/page/1/';
        }
        return $urls;
    }

    public function getCountries()
    {
        $encode_countries = [];
        $countries = $this->fileToArray(__DIR__ . '/config/countries');
        foreach ($countries as $country) {
            $encode_countries[$country] = $this->urlencode($country);
        }
//        dd($encode_countries);
        return $encode_countries;
    }

}
