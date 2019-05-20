<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Services\Kinoparser\Urls\Layouts;

use App\Contracts\Kinoparser\ParserInterface;
use App\Services\Kinoparser\Data\Layouts\CurlKinopoiskDefault;
use App\Services\Kinoparser\Options\CountriesGetterFromFile;

/**
 * Description of ListsOfPersonGetter
 *
 * @author KNovikov
 */
class ListsOfPersonGetter
{

    const PERSON_URLS_LISTS = __DIR__ . '/../../config/person_urls_lists.txt';

    /**
     * @var ParserInterface
     */
    private $parser;

    /**
     * @var CurlKinopoiskDefault
     */
    private $data;

    /**
     * @var CountriesGetterFromFile
     */
    private $countries;

    public function __construct(CountriesGetterFromFile $countries, CurlKinopoiskDefault $data, ParserInterface $parser)
    {

        $this->countries = $countries;
        $this->data = $data;
        $this->parser = $parser;
    }

    public function getUrlsListsByCountry($country): array
    {
        $urls = $this->getUrlsToCount($country);
        $counts = $this->getCountPerson($urls);
//        dd($counts);
        $urls_lists = [];
        foreach ($counts as $url => $count) {
            $count_list = ceil($count / 100);
            for ($i = 1; $i <= $count_list; $i++) {
                $url_list = substr($url, 0, -2) . $i . '/';
                $urls_lists[] = $url_list;
            }
        }

        $fp = fopen(self::PERSON_URLS_LISTS, 'ab');
        foreach ($urls_lists as $url) {
            fwrite($fp, $url . PHP_EOL);
        }
        fclose($fp);

        return $urls_lists;
    }

    private function getCountPerson($urls)
    {
//        $urls = $this->getUrlsToCount();
        $counts = [];
        foreach ($urls as $url) {
            $data = $this->data->getData($url);
//            echo $data;
//            dd($data);
            $title = $this->parser->parse($data, './/title');
//            dd($title);
            if (preg_match('/\(([^()]*)\)/', $title[0], $matches)) {
                $count = $matches[1];
                $counts[$url] = $count;
//                dd($counts);
            }
        }
        return $counts;
//        dd($counts);
    }

    private function getUrlsToCount($country)
    {
//        $countries = $this->countries->getCountries();
//        foreach ($countries as $country) {
//            $urls[] = 'https://www.kinopoisk.ru/s/type/people/list/1/order/relevant/m_act[sex]/male/m_act[location]/' . $this->urlencode($country) . '/page/1/';
//            $urls[] = 'https://www.kinopoisk.ru/s/type/people/list/1/order/relevant/m_act[sex]/female/m_act[location]/' . $this->urlencode($country) . '/page/1/';
//        }
//        dd($urls);
        $urls[] = 'https://www.kinopoisk.ru/s/type/people/list/1/order/relevant/m_act[sex]/male/m_act[location]/' . $this->urlencode($country) . '/page/1/';
        $urls[] = 'https://www.kinopoisk.ru/s/type/people/list/1/order/relevant/m_act[sex]/female/m_act[location]/' . $this->urlencode($country) . '/page/1/';

        return $urls;
    }

    private function urlencode($string)
    {
        $value = iconv('utf-8', 'windows-1251', $string);
        return urlencode($value);
    }

}
