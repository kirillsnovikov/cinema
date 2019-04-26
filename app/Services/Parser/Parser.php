<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Services\Parser;

use App\Services\Parser\Interfaces\ParserInterface;
use App\Services\Parser\Options;
use App\Services\Parser\PersonUrlsParser;
//use App\Services\Parser\Exception\ProxyException;
//use App\Services\Parser\Autodata;
use DOMDocument;
use DomXPath;
use Illuminate\Http\RedirectResponse;

/**
 * Description of Parser
 *
 * @author KNovikov
 */
class Parser extends Options implements ParserInterface
{

    public $ch;
    public $logs;
    public $inputs;
    public $type;
    public $post;
    public $urls;
    public $last_url;
    public $paths;
    public $proxies;
    public $proxy_type;
    public $user_agents;
    public $cookie;
    public $headers;
    public $data;
    public $xpath;
    public $result;
    public $attributes;

    //put your code here

    public function __construct($inputs = null)
    {
        if ($inputs != null) {
            $this->getInputs($inputs);
        }
    }

    public function start($inputs)
    {
//        dd($inputs);
//        dd($this->headers);
//        dd($this->logs);
        $person = new PersonUrlsParser;
        $person->person();
        
//        dd('fkfkfkfk');
//        $this->getXPath();
//        dd($this->xpath);
//        ob_start();
//
//        $data = $this->objectFromJsonFile('storage/temp/moonwalk_movies_foreign.json');
//        dd($data['report']['movies'][0]);
//
//        $this->getOptions($inputs);
////        dd($this->headers);
////        file_put_contents($this->cookie, '');
//        $this->curlInit();
//        $url = 'http://moonwalk.cc/api/movies_updates.json?api_token=aa7bef164f7f42be5bf2038c06464728';
//        $this->getData($url);
//        dd($this->data);
//
//
//
//        dd($this->data);

//        $this->curlClose();
//
//        foreach ($this->urls as $url) {
//            $this->getData($url);
//            $this->getParseResult($this->paths);
//        }
//        $this->curlClose();
    }

    public function checkProxy($inputs)
    {
        ob_start();
        $this->inputs = $inputs;
        $this->checkProxies();
    }

    public function objectToTempFile($value, $filename)
    {
        $str_value = serialize($value);

        $f = fopen($filename, 'wb');
        fwrite($f, $str_value);
        fclose($f);
    }

    public function objectToFile($value, $filename)
    {
        $str_value = serialize($value);

        $f = fopen($filename, 'w');
        fwrite($f, $str_value);
        fclose($f);
    }

    public function objectFromFile($filename)
    {
        $file = file_get_contents($filename);
        $value = unserialize($file);
        return $value;
    }

    public function objectFromJsonFile($filename)
    {
        return json_decode(file_get_contents($filename), TRUE);
    }

    public function getData($url, $referer = null, $post = null)
    {
        $try = TRUE;


        while ($try) {
//            $user_agent = 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/71.0.3578.98 Safari/537.36';
            $user_agent = $this->user_agents[mt_rand(0, count($this->user_agents) - 1)];
//            dd($user_agent);
            $this->curlSetOpt($this->ch, $url, $post, $user_agent);
            $this->curlExec();
//            dd($this->data);
            $response_code = curl_getinfo($this->ch, CURLINFO_RESPONSE_CODE);
            $this->last_url = curl_getinfo($this->ch, CURLINFO_EFFECTIVE_URL);
            $strlen_data = strlen($this->data);

            if ($response_code != 200 || $strlen_data < 10 || preg_match('/captcha-page/', $this->data, $options)) {
                $try = TRUE;
                fwrite($this->logs, ' --- ' . $response_code . ' --- ' . $strlen_data . ' --- BAD RESULT!!' . PHP_EOL);
                if (!empty($options)) {
                    fwrite($this->logs, $options[0] . ' --- CAPTCHA!!!' . PHP_EOL);
                }
//                echo $url . ' --- ' . $response_code . ' --- ' . $strlen_data . ' --- BAD RESULT!! <br>';
            } else {
                $try = FALSE;
                fwrite($this->logs, ' --- ' . $response_code . ' --- ' . $strlen_data . ' --- SUCCESS!!' . PHP_EOL);
//                dd($last_url);
//                echo $url . ' --- ' . $response_code . ' --- ' . $strlen_data . ' --- OK!! <br>';
            }
            usleep(mt_rand(1000000, 3000000));
//            ob_flush();
//            flush();
        }

//        usleep(mt_rand(2000000, 3000000));
//        echo $this->data;
    }

    public function curlSetOpt($ch, $url, $post, $user_agent, $referer = null, $timeout = 15, $connecttimeout = 10)
    {
//        curl_setopt($ch, CURLOPT_URL, $url);
//        curl_setopt($ch, CURLOPT_USERAGENT, $user_agent);
//        curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
//        curl_setopt($ch, CURLINFO_HEADER_OUT, true);
//        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
//        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//        curl_setopt($ch, CURLOPT_COOKIEJAR, $this->cookie);
//        curl_setopt($ch, CURLOPT_COOKIEFILE, $this->cookie);
//        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
//        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
//        curl_setopt($ch, CURLOPT_HEADER, 0);
//        curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
//        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $connecttimeout);

//        if ($referer != null) {
//            curl_setopt($ch, CURLOPT_REFERER, $referer);
//        }

        if ($this->proxies != null) {

            $proxy = $this->proxies[mt_rand(0, count($this->proxies) - 1)];
            curl_setopt($ch, CURLOPT_PROXY, $proxy);
            curl_setopt($ch, CURLOPT_HTTPPROXYTUNNEL, True);

            if (strcasecmp($this->proxy_type, 'socks4') == 0) {
                curl_setopt($ch, CURLOPT_PROXYTYPE, CURLPROXY_SOCKS4);
            } elseif (strcasecmp($this->proxy_type, 'socks5') == 0) {
                curl_setopt($ch, CURLOPT_PROXYTYPE, CURLPROXY_SOCKS5);
            }
        }

        if ($post != null) {
            curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
        }
    }

    public function curlInit()
    {
        $this->ch = curl_init();
    }

    public function curlExec()
    {
        $this->data = curl_exec($this->ch);
    }

    public function curlClose()
    {
        curl_close($this->ch);
    }

    public function getParseAttributes($paths)
    {
        $this->getXPath();
        $this->attributes = [];

        foreach ($paths as $key => $path) {
            $elements = $this->xpath->query($path);
//            dd($elements);
            foreach ($elements as $node) {
                $name = trim($node->nodeName);
                $value = trim($node->nodeValue);
                $this->attributes[$key][$name] = $value;
            }
        }
    }

    public function getParseResult($paths)
    {
        $this->getXPath();
        $this->result = [];

        /* @var $paths type */
        foreach ($paths as $key => $path) {
            $elements = $this->xpath->query($path);
//            dd($elements[0]);
            if (count($elements) > 1) {
                foreach ($elements as $node) {
//                dump($node);
                    $name = trim($node->nodeName);
//                dump();
                    $value = trim($node->nodeValue);
                    $this->result[$key][] = $value;
                }
            } else {
                foreach ($elements as $node) {
//                dump($node);
                    $name = trim($node->nodeName);
//                dump();
                    $value = trim($node->nodeValue);
                    $this->result[$key] = $value;
                }
            }
        }
//        dd($this->result);
    }

    public function getElementsResult($path)
    {
        $elements = $this->xpath->query($path);
//        dd($elements[0]->textContent);
        $this->result = [];
        foreach ($elements as $node) {
//                dump($node);
//            $name = trim($node->nodeName);
//                dump();
            $value = trim($node->nodeValue);
            $this->result[] = $value;
        }
    }

    public function getXPath()
    {
        $dom = new DOMDocument;
        $dom->loadHTML($this->data, LIBXML_NOERROR);
        $this->xpath = new DomXPath($dom);
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

    public function zhorzh()
    {
        $urls = ['https://static.chipdip.ru/lib/991/DOC003991974.jpg',
            'https://static.chipdip.ru/lib/991/DOC003991978.jpg',
            'https://static.chipdip.ru/lib/991/DOC003991982.jpg',
            'https://static.chipdip.ru/lib/991/DOC003991949.jpg',
            'https://static.chipdip.ru/lib/991/DOC003991960.jpg',
            'https://static.chipdip.ru/lib/991/DOC003991966.jpg',
            'https://static.chipdip.ru/lib/991/DOC003991956.jpg',
            'https://static.chipdip.ru/lib/991/DOC003991940.jpg',
            'https://static.chipdip.ru/lib/991/DOC003991944.jpg',
            'https://static.chipdip.ru/lib/991/DOC003991970.jpg',
        ];

        foreach ($urls as $key => $url) {
//            $url = 'http://img.yandex.net/i/www/logo.png';
            $image = file_get_contents($url);
            dd($image);
            $path = './images/logo.png';
            file_put_contents($path, file_get_contents($url));
        }
    }

}
