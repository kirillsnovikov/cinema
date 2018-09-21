<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Services\Parser;

use App\Services\Parser\CheckProxy;

/**
 * Description of Options
 *
 * @author KNovikov
 */
class Options extends CheckProxy
{

    public function getOptions($inputs)
    {
        $this->inputs = $inputs;
        $type = $this->inputs['type_parser'];

        $methods = get_class_methods($this);
        dd($methods);

        if (array_key_exists('type_parser', $this->inputs)) {
            $get_paths_method = 'get' . $type . 'Paths';
            $get_urls_method = 'get' . $type . 'Urls';
            $this->$get_paths_method();
            $this->$get_urls_method();
        }
    }

    public function getKinopoiskMovieUrls()
    {
        if (array_key_exists('kp_id_from', $this->inputs) && array_key_exists('kp_id_to', $this->inputs)) {
            for ($i = $this->inputs['kp_id_from']; $i <= $this->inputs['kp_id_to']; $i++) {
                $url = 'https://www.kinopoisk.ru/film/' . $i;
                $this->urls[] = $url;
            }
        } elseif (array_key_exists('use_urls', $this->inputs)) {
            $this->urls = $this->trim('storage/temp/kinopoisk_movie_urls.txt');
        }
    }

    public function getKinopoiskPersonUrls()
    {
        if ($this->inputs['kp_id_from'] != null && $this->inputs['kp_id_to'] != null) {
            for ($i = $this->inputs['kp_id_from']; $i <= $this->inputs['kp_id_to']; $i++) {
                $url = 'https://www.kinopoisk.ru/name/' . $i;
                $this->urls[] = $url;
            }
        } elseif (array_key_exists('use_urls', $this->inputs)) {
            $this->urls = $this->trim('storage/temp/kinopoisk_person_urls.txt');
        }
    }

    public function getKinopoiskMoviePaths()
    {
        $this->getPaths();

        $this->paths['title'] = ".//h1[@itemprop='name']";
        $this->paths['title_en'] = ".//h1[@itemprop='name']";
        $this->paths['year'] = ".//h1[@itemprop='name']";
        $this->paths['producer'] = ".//h1[@itemprop='name']";
        $this->paths['actors'] = ".//h1[@itemprop='name']";
        $this->paths['country'] = ".//h1[@itemprop='name']";
        $this->paths['duration'] = ".//h1[@itemprop='name']";
    }

    public function getKinopoiskPersonPaths()
    {
        $this->getPaths();

        $this->paths['name'] = ".//h1[@itemprop='name']";
        $this->paths['name_en'] = ".//h1[@itemprop='name']";
        $this->paths['tale'] = ".//h1[@itemprop='name']";
        $this->paths['birth_date'] = ".//h1[@itemprop='name']";
        $this->paths['death_date'] = ".//h1[@itemprop='name']";
        $this->paths['birth_place'] = ".//h1[@itemprop='name']";
        $this->paths['death_place'] = ".//h1[@itemprop='name']";
    }

    public function getPaths()
    {
        $this->paths = [];
        foreach ($this->inputs as $key => $path) {
            if (strcasecmp($path, 'path') == 0) {
                $this->paths[$key] = $path;
            }
        }
    }

    public function trim($file)
    {
        return file($file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    }

}
