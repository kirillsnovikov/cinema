<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Services\Kinoparser\Options;

use App\Contracts\Kinoparser\CountriesGetterInterface;

/**
 * Description of CountriesGetterFromFile
 *
 * @author KNovikov
 */
class CountriesGetterFromFile implements CountriesGetterInterface
{

    const COUNTRIES_FILE = __DIR__ . '/../config/countries.txt';

    public function getCountries(): array
    {
        $countries = [];

        if (realpath(self::COUNTRIES_FILE)) {
            $countries = array_unique(file(self::COUNTRIES_FILE, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES), SORT_STRING);
        }
        return $countries;
    }

}
