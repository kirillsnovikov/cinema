<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Services\Kinoparser\Urls\Layouts;

use App\Services\Kinoparser\Data\Layouts\CurlKinopoiskDefault;
use App\Services\Kinoparser\Options\CountriesGetterFromFile;

/**
 * Description of ListsOfPersonGetter
 *
 * @author KNovikov
 */
class ListsOfPersonGetter
{

    /**
     * @var CurlKinopoiskDefault
     */
    private $data;

    /**
     * @var CountriesGetterFromFile
     */
    private $countries;

    public function __construct(CountriesGetterFromFile $countries, CurlKinopoiskDefault $data)
    {
        
        $this->countries = $countries;
        $this->data = $data;
    }
    
    private function getCountPerson()
    {
        $countries = $this->countries->getCountries();
        
    }
    
    private function urlencode($string)
    {
        $value = iconv('utf-8', 'windows-1251', $string);
        return urlencode($value);
    }
}
