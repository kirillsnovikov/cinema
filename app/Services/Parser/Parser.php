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
            $this->getParseResult($this->paths);
        }
        $this->curlClose();


//        file_put_contents('storage/temp/user_agents.jpg', $this->data);
//        echo $this->data;
    }

    public function autodata($inputs)
    {
        ob_start();
//        dd($inputs);
        $this->getOptions($inputs);

//        инициализируем новую сессию курла
        $this->curlInit();
        $autodata = new Autodata();
        $vars = get_object_vars($this);
//        dd(stripos($this->type, 'autodatalogin'));
//        dd($vars);
//        проверка на тип парсера для ссылок (Link)
        if (stripos($this->type, 'login') > 0) {
            $url = 'https://workshop.autodata-group.com/login?destination=node';
//            file_put_contents($this->cookie, ''); //создаем новые куки
//            dd('logloglog');
            $this->getData($url, 'https://workshop.autodata-group.com/'); //получаем данные страницы
//            dd($this->data);
            $this->getParseResult($this->paths); //выдергиваем данные скрытых полей через xpath и записываем в result
//            dd($this->result);
            $this->post = $autodata->getLoginParameters($this->result); //формируем post данные из полученного result
//            dd($this->post);
            $this->getData($url, $url, $this->post); //логинимся пост запросом
//            dd($this->data);
            if (preg_match("/главную/i", $this->data)) {
                return 'Успешно зашли в систему!';
            } else {
                return 'Возможно, возникли ошибки при входе в систему!';
            }
        } elseif (stripos($this->type, 'link') > 0) {
//            $this->getData('https://workshop.autodata-group.com/w1/model-selection/manufacturers/', $this->last_url);
//            $json_manufactures = json_decode($this->data, true);
//            $manufactures = $autodata->getManufactures($json_manufactures);
////            $models = [];
//            foreach ($manufactures as $key => $value) {
//                $this->getData($value['link'], $this->last_url);
//                $json_models = json_decode($this->data, true);
//                foreach ($json_models as $model) {
//                    if (!array_key_exists('ocurrences', $model)) {
//                        $model['link_engine'] = 'https://workshop.autodata-group.com/w1/manufacturers/' . $value['uid'] . '/' . $model['uid'] . '/engines?route_name=engine-oil&module=TD';
//                        $manufactures[$key][] = $model;
////                        https://workshop.autodata-group.com/selection/save-in-jobfolder/0/undefined
//                    }
//                }
////                dd($manufactures);
//            }
////            $file = file_get_contents('storage/temp/manufactures.json');
////            $array = $this->objectFromFile();
//            $this->objectToFile($manufactures);
//            $array = $this->objectFromFile();
//            
//            dump($array);

            $this->getData('http://arts.restshot.ru/login');
            $this->getParseAttributes($this->paths);
            dump($this->attributes);

            return 'Сбор ссылок закончен!';
        } elseif (stripos($this->type, 'logout') > 0) {
//            dd('outoutout');
            $this->getData('https://workshop.autodata-group.com/user/logout', 'https://workshop.autodata-group.com/node');
            if (preg_match("/успешно/i", $this->data)) {
                return 'Успешно вышли из системы!';
            } else {
                return 'Возможно, возникли ошибки при выходе из системы!';
            }
//            dd($this->data);
        }
        $this->curlClose();

//        $autodata = new Autodata();
//        $autodata->getHiddenKeys();
    }

    public function checkProxy($inputs)
    {
        ob_start();
        $this->inputs = $inputs;
        $this->checkProxies();
    }

//    public function encodeJson($json)
//    {
//        $result = json_encode($json);
////        echo $result;
//    }
//
//    public function decodeJson($json)
//    {
//        dd($json);
//        $result = json_decode($json);
////        dd($result->{'friends'}[0]->{'id'});
//        dd($result->friends[0]->id);
//    }

    public function objectToFile($value, $filename = 'storage/temp/array.txt')
    {
        $str_value = serialize($value);

        $f = fopen($filename, 'w');
        fwrite($f, $str_value);
        fclose($f);
    }

    public function objectFromFile($filename = 'storage/temp/array.txt')
    {
        $file = file_get_contents($filename);
        $value = unserialize($file);
        return $value;
    }

    public function getData($url, $referer = null, $post = null)
    {
        $try = TRUE;


        while ($try) {
            $user_agent = $this->user_agents[mt_rand(0, count($this->user_agents) - 1)];
            $this->curlSetOpt($url, $post, $user_agent, $referer);
            $this->data = curl_exec($this->ch);
            $response_code = curl_getinfo($this->ch, CURLINFO_RESPONSE_CODE);
            $this->last_url = curl_getinfo($this->ch, CURLINFO_EFFECTIVE_URL);
            $strlen_data = strlen($this->data);

            if ($response_code != 200 || $strlen_data < 10) {
                $try = TRUE;
                echo $url . ' --- ' . $response_code . ' --- ' . $strlen_data . ' --- BAD RESULT!! <br>';
            } else {
                $try = FALSE;
//                dd($last_url);
                echo $url . ' --- ' . $response_code . ' --- ' . $strlen_data . ' --- OK!! <br>';
            }
            ob_flush();
            flush();
        }
//        usleep(mt_rand(2000000, 6000000));
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

    public function getParseAttributes($paths)
    {
        $this->getXPath();
        $this->attributes = [];

        foreach ($paths as $key => $path) {
            $elements = $this->xpath->query($path);
            foreach ($elements as $node) {
                $name = trim($node->nodeName);
                $value = trim($node->nodeValue);
                $this->attributes[$name] = $value;
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
        dd($this->result);
    }

    public function getElementsResult($elements)
    {
        foreach ($elements as $node) {
//                dump($node);
            $name = trim($node->nodeName);
//                dump();
            $value = trim($node->nodeValue);
            $this->result[$key][] = $value;
        }
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
