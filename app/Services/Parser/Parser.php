<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Services\Parser;

use App\Services\Parser\Interfaces\ParserInterface;

/**
 * Description of Parser
 *
 * @author KNovikov
 */
class Parser implements ParserInterface
{

    public $inputs;
    public $urls;

    //put your code here

    public function __construct($inputs = null)
    {
        if ($inputs != null) {
            $this->start($inputs);
        }
    }

    public function start($inputs)
    {
        $this->getInputs($inputs);
        $this->getKinopoiskUrls();
    }

    public function getKinopoiskUrls()
    {
        if (!file_exists('storage/temp/')) {
            mkdir('storage/temp/', 0666, TRUE);
        }
        $fp = fopen('storage/temp/kinopoisk_urls.txt', "wb");
        //$fp = fopen(__DIR__ . '\\kinopoisk_urls.txt', "ab");
        for ($i = $this->inputs['kp_id_from']; $i <= $this->inputs['kp_id_to']; $i++) {
            $url = 'https://www.kinopoisk.ru/film/' . $i;
            fwrite($fp, $url . PHP_EOL);
            $this->urls[] = $url;
        }
        fclose($fp);
        //dd($this->urls);
    }

    public function getParseParameters()
    {
        echo 'Parser START!';
        foreach ($this->inputs as $key => $input) {
            echo ('<br>' . $key . ': ' . $input);
        }
    }

    public function getInputs($inputs)
    {
        $this->inputs = $inputs;
    }

}
