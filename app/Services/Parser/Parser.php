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
        //$_SERVER["HTTP_X_FORWARDED_FOR"];
        $fp = $this->socks_connect('78.132.143.104', 4145, 'google.com', 80);
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
        $ip = '109.248.68.115';
        $port = '4145';
        $socks = fsockopen($ip, $port);
        fwrite($socks, 'asdf');
        echo \fgets($socks, 128);
        fclose($socks);
        dd($socks);
        foreach ($this->inputs as $key => $input) {
            echo ('<br>' . $key . ': ' . $input);
        }
    }

    public function getInputs($inputs)
    {
        $this->inputs = $inputs;
    }

    public function socks_connect($host, $port, $dh, $dp) //адрес скоса, порт сокса, адрес сайта, порт сайта.
    {
        $result = true;
        $f = fsockopen($host, $port);
        if ($result) {
            $h = gethostbyname($dh);
            preg_match("#(\d+)\.(\d+)\.(\d+)\.(\d+)#", $h, $m);
            //dd($m);
            fwrite($f, '\x04\x01\x00');
            //dd($f);
            dd($r = fread($f, 1));
            if (!(ord($r[0]) == 5 && ord($r[1]) == 0)) {
                $result = false;
            }
            if ($result) {
                fwrite($f, "\x05\x01\x00\x01" . chr($m[1]) . chr($m[2]) . chr($m[3]) . chr($m[4]) . chr($dp / 256) . chr($dp % 256));
                $r = fread($f, 10);
                if (!(ord($r[0]) == 5 and ord($r[1]) == 0)) {
                    return false;
                } else {
                    return $f;
                }
            }
        }
    }

}
