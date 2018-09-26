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

        if (array_key_exists('type_parser', $this->inputs)) {
            $get_paths_method = 'get' . $type . 'Paths';
            $get_urls_method = 'get' . $type . 'Urls';
            $this->$get_paths_method();
            $this->$get_urls_method($type);
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
            'password' => 'Ng620#Qtz'
        ];
    }

    public function getCookie()
    {
        $this->cookie = __DIR__ . '\\cookie.txt';
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
            'Cache-Control: max-age=100',
            'Connection: keep-alive',
            'Keep-Alive: 300',
            'Accept-Charset: ISO-8859-1,utf-8;q=0.7,*;q=0.7',
            'X-Requested-With: XMLHttpRequest'
        ];
    }

    public function getUserAgents()
    {
        $file_user_agents = 'storage/temp/user_agents.txt';
        $default_user_agent = $_SERVER['HTTP_USER_AGENT'];
        $this->user_agents = [];

        if (array_key_exists('use_user_agent', $this->inputs) && file_exists($file_user_agents)) {
            $this->user_agents = $this->trim($file_user_agents);
        } else {
            $this->user_agents[] = $default_user_agent;
        }
    }

    public function getProxies()
    {
        $this->proxy_type = $this->inputs['use_proxy'];
        $file_proxy = 'storage/temp/good_' . $this->proxy_type . '.txt';
        $this->proxies = $this->trim($file_proxy);
    }

    public function getKinopoiskMovieUrls($type)
    {
        $this->getUrls($type);
    }

    public function getKinopoiskPersonUrls($type)
    {
        $this->getUrls($type);
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
        }

        if ($this->inputs['kp_id_from'] != null && $this->inputs['kp_id_to'] != null) {
            for ($i = $this->inputs['kp_id_from']; $i <= $this->inputs['kp_id_to']; $i++) {
                $url = $url_part . $i;
                $this->urls[] = $url;
            }
        } elseif (array_key_exists('use_urls', $this->inputs)) {
            $this->urls = $this->trim($file);
        }
    }

    public function getPaths($path_values)
    {
        $this->paths = [];
        foreach ($this->inputs as $key => $path) {
            if (strcasecmp($path, 'path') == 0) {
                $this->paths[$key] = $path;
            }
        }
        
        foreach ($path_values as $key => $value) {
            if (array_key_exists($key, $this->paths)) {
                $this->paths[$key] = $value;
            }
        }
    }

    public function trim($file)
    {
        return file($file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    }

}
