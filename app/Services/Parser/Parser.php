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
use App\Services\Parser\Autodata;
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
    public $type;
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
        $this->curlInit();
//        dd($this->inputs);
//        dd($this->paths);

        foreach ($this->urls as $url) {

            $this->getData($url);
//            echo $this->data;
//            $this->encodeJson($this->inputs);
//            $this->decodeJson($this->data);
//            $this->getParseResult($this->paths);
        }
        $this->curlClose();


//        file_put_contents('storage/temp/user_agents.jpg', $this->data);
//        echo $this->data;
    }

    public function autodata($inputs)
    {
//        ob_start();
        $this->getOptions($inputs);
        $autodata = new Autodata();
        
//        проверка на тип парсера для ссылок (Link)
        if (stripos($this->type, 'datalink')) {
//            создаем новые куки
            file_put_contents($this->cookie, '');
//            инициализируем новую сессию курла
            $this->curlInit();
//        dd($this->paths);
            foreach ($this->urls as $url) {
//                получаем данные страницы
                $this->getData($url);
//                выдергиваем нужные данные через xpath и записываем в result
                $this->getParseResult($this->paths);
//                формируем post данные из полученного result
                $this->post = $autodata->getLoginParameters($this->result);
                $this->getData($url, $this->post);
                dd($this->data);
                $vars = get_object_vars($this);
//                dd($this->post);
            }
        }

//        $autodata = new Autodata();
//        $autodata->getHiddenKeys();
    }

    public function checkProxy($inputs)
    {
        ob_start();
        $this->inputs = $inputs;
        $this->checkProxies();
    }

    public function encodeJson($json)
    {
        $result = json_encode($json);
        echo $result;
    }

    public function decodeJson($json)
    {
        dd($json);
        $result = json_decode($json);
//        dd($result->{'friends'}[0]->{'id'});
        dd($result->friends[0]->id);
    }

    public function getData($url, $post = null)
    {
        $try = TRUE;


        while ($try) {
            $user_agent = $this->user_agents[mt_rand(0, count($this->user_agents) - 1)];
            $referer = 'https://kinopoisk.ru';
            $this->curlSetOpt($url, $post, $user_agent, $referer);
            $this->data = curl_exec($this->ch);
            $response_code = curl_getinfo($this->ch, CURLINFO_RESPONSE_CODE);
            $strlen_data = strlen($this->data);

            if ($response_code != 200 || $strlen_data < 100) {
                $try = TRUE;
//                echo $url . ' --- ' . $response_code . ' --- ' . $strlen_data . ' --- BAD RESULT!! <br>';
            } else {
                $try = FALSE;
//                echo $url . ' --- ' . $response_code . ' --- ' . $strlen_data . ' --- OK!! <br>';
            }
//            ob_flush();
//            flush();
        }
//        echo $this->data;
    }

    public function curlInit()
    {
        $this->ch = curl_init();
    }

    public function curlClose()
    {
        curl_close($this->ch);
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
        $this->result = [];

        /* @var $paths type */
        foreach ($paths as $key => $path) {
            $elements = $this->xpath->query($path);
            foreach ($elements as $node) {
                $value = trim($node->nodeValue);
                $this->result[$key] = $value;
            }
        }
//        dd($this->result);
    }

    public function getXPath()
    {
        $dom = new DOMDocument;
        $dom->loadHTML($this->data, LIBXML_NOERROR);
        $this->xpath = new DomXPath($dom);
//        dd($this->xpath);
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
