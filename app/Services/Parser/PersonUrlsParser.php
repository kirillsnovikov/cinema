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

    public function person()
    {
        $this->getCountries();
    }
    
    public function getCountries()
    {
        $encode_countries = [];
        $countries = $this->fileToArray(__DIR__ . '/countries');
        foreach ($countries as $country) {
            $encode_countries[$country] = $this->urlencode($country);
        }
        dd($encode_countries);
        return $encode_countries;
    }

}
