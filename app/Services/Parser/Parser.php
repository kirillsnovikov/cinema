<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Services\Parser;

use App\Services\Parser\Interfaces\ParserInterface;
use App\Services\Parser\Options;
use App\Services\Parser\Exception\ProxyException;
use DOMDocument;
use DomXPath;

/**
 * Description of Parser
 *
 * @author KNovikov
 */
class Parser extends Options implements ParserInterface
{

    public $ch;
    public $inputs;
    public $post;
    public $urls;
    public $paths;
    public $proxies;
    public $proxy_type;
    public $user_agents;
    public $cookie;
    public $headers;
    public $data;
    public $xpath;
    public $result;

    //put your code here

    public function __construct($inputs = null)
    {
        if ($inputs != null) {
            $this->getInputs($inputs);
        }
    }

    public function start($inputs)
    {
        ob_start();
        $this->getOptions($inputs);
        file_put_contents($this->cookie, '');
//        dd($this->paths);

        foreach ($this->urls as $url) {
            $this->getRealData($url);
            $this->getParseResult($this->paths);
        }

        echo $this->data;
    }

    public function checkProxy($inputs)
    {
        ob_start();
        $this->inputs = $inputs;
        $this->checkProxies();
    }

    public function getRealData($url, $post = null)
    {
        $try = TRUE;


        while ($try) {
            $user_agent = $this->user_agents[mt_rand(0, count($this->user_agents) - 1)];
            $referer = 'https://kinopoisk.ru/';
            $this->ch = curl_init();
            $this->curlSetOpt($url, $post, $user_agent, $referer);
            $this->data = curl_exec($this->ch);
            $response_code = curl_getinfo($this->ch, CURLINFO_RESPONSE_CODE);
            $strlen_data = strlen($this->data);

            curl_close($this->ch);

            $try = (($response_code != 200) && ($strlen_data == 0));
        }
    }

    public function curlSetOpt($url, $post, $user_agent, $referer = null, $timeout = 15, $connecttimeout = 10)
    {
        curl_setopt($this->ch, CURLOPT_URL, $url);
        curl_setopt($this->ch, CURLOPT_USERAGENT, $user_agent);
        curl_setopt($this->ch, CURLOPT_HTTPHEADER, $this->headers);
        curl_setopt($this->ch, CURLINFO_HEADER_OUT, true);
        curl_setopt($this->ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($this->ch, CURLOPT_COOKIEJAR, $this->cookie);
        curl_setopt($this->ch, CURLOPT_COOKIEFILE, $this->cookie);
        curl_setopt($this->ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($this->ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($this->ch, CURLOPT_HEADER, 0);
        curl_setopt($this->ch, CURLOPT_TIMEOUT, $timeout);
        curl_setopt($this->ch, CURLOPT_CONNECTTIMEOUT, $connecttimeout);

        if ($referer != null) {
            curl_setopt($this->ch, CURLOPT_REFERER, $referer);
        }

        if ($this->proxies != null) {

            $proxy = $this->proxies[mt_rand(0, count($this->proxies) - 1)];
            curl_setopt($this->ch, CURLOPT_PROXY, $proxy);
            curl_setopt($this->ch, CURLOPT_HTTPPROXYTUNNEL, True);

            if (strcasecmp($this->proxy_type, 'socks4') == 0) {
                curl_setopt($this->ch, CURLOPT_PROXYTYPE, CURLPROXY_SOCKS4);
            } elseif (strcasecmp($this->proxy_type, 'socks5') == 0) {
                curl_setopt($this->ch, CURLOPT_PROXYTYPE, CURLPROXY_SOCKS5);
            }
        }

        if ($post != null) {
            curl_setopt($this->ch, CURLOPT_POSTFIELDS, $post);
        }
    }

    public function getParseResult($paths)
    {
        $this->getXPath();
//        $elements = [];
        $this->result = [];

        /* @var $paths type */
        foreach ($paths as $key => $path) {
            $elements = $this->xpath->query($path);
//            dd($elements);
            foreach ($elements as $node) {
//                dd($node);
                $value = trim($node->nodeValue);
                $this->result[$key][] = $value;
            }
        }






        dd($this->result);
    }

    public function getXPath()
    {
        $dom = new DOMDocument;
        $dom->loadHTML($this->data, LIBXML_NOERROR);
        $this->xpath = new DomXPath($dom);
    }

    public function getHiddenKeys()
    {
        $data = $this->getRealData('https://workshop.autodata-group.com/login?destination=node');
//        dd('asdf');
        if ($data) {

            $dom = new DOMDocument;    //создаем объект
            $dom->loadHTML($data, LIBXML_NOERROR);
            $xpath = new DomXPath($dom);
            $key1 = ".//input[@type='hidden'][1]/@value";
            $key2 = ".//input[@type='hidden'][2]/@value";
            $post = [];
//            $post = [
//                'name' => 'hhh',
//                'pass' => '123123'
//            ];
//                $path = ".//form[@type='hidden']/a/@href";
//            $error = ".//div[@class='p404']";
//                 $nodeList = $xpath->query($path);
//                 dd('asdf');

            $nodeList_1 = $xpath->query($key1);
            $nodeList_2 = $xpath->query($key2);
            //dd($nodeList);
            if (count($nodeList_1) > 0 && count($nodeList_2) > 0) {

                foreach ($nodeList_1 as $node_1) {
                    // добавляем это чтото в массив в нужный ключ
                    $value_1 = $node_1->nodeValue;
                    //dd(!in_array($link, $results));

                    $post['form_build_id'] = $value_1;
                }

                foreach ($nodeList_2 as $node_2) {
                    // добавляем это чтото в массив в нужный ключ
                    $value_2 = $node_2->nodeValue;
                    //dd(!in_array($link, $results));

                    $post['form_id'] = $value_2;
                }
                $post['name'] = 'sidor.ivanov';
                $post['pass'] = '30-08--2018';
                return $post;
            } else {
                return FALSE;
            }
        }
    }

    public function mkdirTemp()
    {
        if (!file_exists('storage/temp/')) {
            mkdir('storage/temp/', 0666, TRUE);
        }
    }

    public function _host2int($host)
    {
        $ip = gethostbyname($host);
        if (preg_match("/(\d+)\.(\d+)\.(\d+)\.(\d+)/", $ip, $matches)) {
            //dd($matches);
            $retVal = pack("C4", $matches[1], $matches[2], $matches[3], $matches[4]);
        }
        return $retVal;
    }

    public function hex2bin($dump)
    {
        $dump = str_replace(' ', '', $dump); // вырезаем пробелы  

        $res = '';
        for ($i = 0; $i < strlen($dump); $i += 2) {
            $bt = $dump[$i] . $dump[$i + 1];
            echo $bt . '<br>';
            $res = $res . chr(hexdec($bt)); // переводим в dec и возвращаем символ по ascii коду 
            //echo $res.'<br>';
        }
        //dd($res);
        return $res;
    }

    public function mb_ucfirst($word)
    {
        return mb_strtoupper(mb_substr($word, 0, 1, 'UTF-8'), 'UTF-8') . mb_substr(mb_convert_case($word, MB_CASE_LOWER, 'UTF-8'), 1, mb_strlen($word), 'UTF-8');
    }

    public function getRealMultiData($urls)
    {
        $mh = curl_multi_init();
        $handles = [];

        foreach ($urls as $url) {
            $ch = curl_init($url);


            $user_agent = $user_agents[mt_rand(0, count($user_agents) - 1)];

            $headers = [
                'Accept: text/xml,application/xml,application/xhtml+xml,text/html;q=0.9,text/plain;q=0.8,image/png,*/*;q=0.5',
                'Cache-Control: max-age=100',
                'Connection: keep-alive',
                'Keep-Alive: 300',
                'Accept-Charset: ISO-8859-1,utf-8;q=0.7,*;q=0.7',
                'X-Requested-With: XMLHttpRequest',
            ];


            curl_setopt($ch, CURLOPT_USERAGENT, $user_agent);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLINFO_HEADER_OUT, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_HEADER, 0);
            curl_setopt($ch, CURLOPT_TIMEOUT, 15);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);

            curl_multi_add_handle($mh, $ch);

            $handles[$url] = $ch;
        }

        dd($handles);



        curl_multi_close($mh);
    }

}
