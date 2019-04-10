<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Services\Parser;

use App\Services\Parser\CheckProxy;
use App\Services\Parser\Autodata;

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
        $this->logs = fopen(__DIR__.'/config/logs', 'wb');

        if (array_key_exists('type_parser', $this->inputs)) {
            $this->type = $this->inputs['type_parser'];
            if (!stripos($this->type, 'logout')) {
//                dd('no lgoout');
                $get_paths_method = 'get' . $this->type . 'Paths';
//            dd($get_paths_method);
                $get_urls_method = 'get' . $this->type . 'Urls';
                $this->$get_paths_method();
                $this->$get_urls_method($this->type);
            }
        }

        if (array_key_exists('use_proxy', $this->inputs)) {
            $this->getProxies();
        }

        $this->getUserAgents();
        $this->getHeaders();
        $this->getCookie();
        $this->getPost();
//        $this->getXPath();
//        $this->getParseResult();
    }

    public function getPost()
    {
        $this->post = [
            'login' => 'ccocc',
            'password' => 'qwerty'
        ];
    }

    public function getCookie()
    {
        if (stripos($this->type, 'data') > 0) {
            $this->cookie = __DIR__ . '\\autodata_cookie.txt';
        } elseif (stripos($this->type, 'poisk') > 0) {
            $this->cookie = __DIR__ . '//kinopoisk_cookie.txt';
        } else {
            $this->cookie = __DIR__ . '/config/cookie.txt';
        }
    }

    public function getHeaders()
    {
        $this->headers = [
//            'Accept: text/xml,application/xml,application/xhtml+xml,text/html;q=0.9,text/plain;q=0.8,image/png,*/*;q=0.5',
//            'Cache-Control: max-age=100',
//            'Content-Type: application/x-www-form-urlencoded; charset=UTF-8',
//            'X-DevTools-Emulate-Network-Conditions-Client-Id: A906F88D7D0FEF7CDF69F949F40CCEAA',
//            'Connection: keep-alive',
//            'Keep-Alive: 300',
//            'Accept-Charset: ISO-8859-1,utf-8;q=0.7,*;q=0.7',
//            'X-Requested-With: XMLHttpRequest',
//            'X-CSRF-Token: 4lF6LGd9-dj_Iwqbgd459dQBkPV6qEFbLHW8'
            'Accept: text/xml,application/xml,application/xhtml+xml,text/html;q=0.9,text/plain;q=0.8,image/png,*/*;q=0.5',
            'Accept-Language: ru-RU,ru;q=0.9,en-US;q=0.8,en;q=0.7',
            'Cache-Control: max-age=100',
            'Connection: keep-alive',
            'Content-Type: application/json',
            'Keep-Alive: 300',
            'Accept-Charset: ISO-8859-1,utf-8;q=0.7,*;q=0.7',
            'X-Requested-With: XMLHttpRequest'
        ];
    }

    public function getUserAgents()
    {
        $file_user_agents = __DIR__ . '/config/user_agents';
        $default_user_agent = $_SERVER['HTTP_USER_AGENT'];
        $this->user_agents = [];

        if (array_key_exists('use_user_agent', $this->inputs) && file_exists($file_user_agents)) {
            $this->user_agents = $this->fileToArray($file_user_agents);
        } else {
            $this->user_agents[] = $default_user_agent;
        }
    }

    public function getProxies()
    {
        $this->proxy_type = $this->inputs['use_proxy'];
        $file_proxy = __DIR__ . '/config/good_' . $this->proxy_type;
        $this->proxies = $this->fileToArray($file_proxy);
    }

    public function getAutodataLoginUrls($type)
    {
        $this->getUrls($type);
    }

    public function getAutodataLinkUrls($type)
    {
        $this->getUrls($type);
    }

    public function getKinopoiskMovieUrls($type)
    {
        $this->getUrls($type);
    }

    public function getKinopoiskPersonUrls($type)
    {
        $this->getUrls($type);
    }

    public function getAutodataLoginPaths()
    {
        $path_values = [
            'form_build_id' => ".//input[@type='hidden'][1]/@value",
            'form_id' => ".//input[@type='hidden'][2]/@value",
        ];

        $this->getPaths($path_values);
    }

    public function getAutodataLinkPaths()
    {
        $path_values = [
            'engine_model_name' => ".//a[@class='engine-code-link']",
            'engine_code_link' => ".//a[@class='engine-code-link']/attribute::*",
        ];

        $this->getPaths($path_values);
    }

    public function getKinopoiskMoviePaths()
    {
        $path_values = [
            'title' => ".//h1[@itemprop='name']",
            'title_en' => ".//h1[@itemprop='name']",
            'year' => ".//h1[@itemprop='name']",
            'producer' => ".//h1[@itemprop='name']",
            'actors' => ".//h1[@itemprop='name']",
            'country' => ".//h1[@itemprop='name']",
            'duration' => ".//h1[@itemprop='name']",
        ];

        $this->getPaths($path_values);
    }

    public function getKinopoiskPersonPaths()
    {
        $path_values = [
            'image' => ".//img[@itemprop='image']/@src",
            'name' => ".//h1[@itemprop='name']",
            'name_en' => ".//span[@itemprop='alternateName']",
            'tale' => ".//table[@class='info']//td[. = 'рост']/following-sibling::td",
            'birth_date' => ".//table[@class='info']//td[. = 'дата рождения']/following-sibling::td",
            'death_date' => ".//table[@class='info']//td[. = 'дата смерти']/following-sibling::td",
            'birth_place' => ".//table[@class='info']//td[. = 'место рождения']/following-sibling::td",
            'death_place' => ".//table[@class='info']//td[. = 'место смерти']/following-sibling::td",
        ];

        $this->getPaths($path_values);
    }

    public function getUrls($type)
    {
        if (stripos($type, 'person') > 0) {
            $url_part = 'https://www.kinopoisk.ru/name/';
            $file = 'storage/temp/kinopoisk_person_urls.txt';
        } elseif (stripos($type, 'movie') > 0) {
            $url_part = 'https://www.kinopoisk.ru/film/';
            $file = 'storage/temp/kinopoisk_movie_urls.txt';
        } elseif (stripos($type, 'data') > 0) {
            $file = 'storage/temp/autodata_urls.txt';
        }

        if (array_key_exists('kp_id_from', $this->inputs) && array_key_exists('kp_id_to', $this->inputs) && $this->inputs['kp_id_from'] != null && $this->inputs['kp_id_to'] != null) {
            for ($i = $this->inputs['kp_id_from']; $i <= $this->inputs['kp_id_to']; $i++) {
                $url = $url_part . $i;
                $this->urls[] = $url;
            }
        } elseif (array_key_exists('use_urls', $this->inputs)) {
            $this->urls = $this->fileToArray($file);
        }
    }

    public function getPaths($path_values)
    {
        $this->paths = [];
        foreach ($this->inputs as $name => $path) {
            if (strcasecmp($path, 'path') == 0) {
                $this->paths[$name] = $path;
            }
        }

        foreach ($this->paths as $key => $value) {
            if (array_key_exists($key, $path_values)) {
                $this->paths[$key] = $path_values[$key];
            } else {
                unset($this->paths[$key]);
            }
        }
    }

    public function fileToArray($file)
    {
        return file($file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    }

    public function urlencode($string)
    {
        $value = iconv('utf-8', 'windows-1251', $string);
        return urlencode($value);
    }

}
