<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Services\Parser;

use App\Services\Parser\Interfaces\ParserInterface;
use App\Services\Parser\CheckProxy;
use App\Services\Parser\Exception\ProxyException;
use DOMDocument;
use DomXPath;

/**
 * Description of Parser
 *
 * @author KNovikov
 */
class Parser implements ParserInterface
{

    public $inputs;
    public $urls;
    public $socks4;
    public $socks5;
    public $https;
    public $data;

    //put your code here

    public function __construct($inputs = null)
    {
        if ($inputs != null) {
            $this->start($inputs);
        }
    }

    public function start($inputs)
    {
        ob_start();

        $this->getInputs($inputs);
        //$this->getTeestoreUrls();
        $this->getTeestoreCardInfo();
        //$this->getKinopoiskMovieUrls();
        //$this->checkProxies();
    }

    public function getKinopoiskMovieUrls()
    {

        $this->mkdirTemp();
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

    public function getTeestoreUrls()
    {

        $this->mkdirTemp();
        $fp = fopen('storage/temp/teestore_urls.txt', "wb");
        //$fp = fopen(__DIR__ . '\\kinopoisk_urls.txt', "ab");
        for ($i = $this->inputs['id_from']; $i <= $this->inputs['id_to']; $i++) {
            $url_man = 'https://teestore.ru/m_tee/' . $i;
            $url_woman = 'https://teestore.ru/w_tee/' . $i;
            fwrite($fp, $url_man . PHP_EOL);
            fwrite($fp, $url_woman . PHP_EOL);
            $this->urls[] = $url_man;
            $this->urls[] = $url_woman;
        }
        fclose($fp);
        //dd($this->urls);
    }

    public function checkProxies()
    {
        $this->mkdirTemp();

        if (array_key_exists('socks4', $this->inputs)) {
            $this->socks4 = $this->trim($this->inputs['socks4']);
            $fp = fopen('storage/temp/good_socks4.txt', "wb");
            $i = 1;
            $sum = count($this->socks4);
            foreach ($this->socks4 as $socks4) {
                echo $i . ' Socks4 from: ' . $sum;
                $socket = explode(':', $socks4);
                $ip = $socket[0];
                $port = $socket[1];
                //dd($port);
                if ($this->socks4($ip, $port)) {
                    fwrite($fp, $socks4 . PHP_EOL);
                }
                $i++;
                flush();
                ob_flush();
            }
            fclose($fp);
        }

        if (array_key_exists('socks5', $this->inputs)) {
            $this->socks5 = $this->trim($this->inputs['socks5']);
            $fp = fopen('storage/temp/good_socks5.txt', "wb");
            $i = 1;
            $sum = count($this->socks5);
            foreach ($this->socks5 as $socks5) {
                echo $i . ' Socks5 from: ' . $sum;
                $socket = explode(':', $socks5);
                $ip = $socket[0];
                $port = $socket[1];
                //dd($port);
                if ($this->socks5($ip, $port)) {
                    fwrite($fp, $socks5 . PHP_EOL);
                }
                $i++;
                ob_flush();
                flush();
            }
            fclose($fp);
        }
    }

    public function getProxies()
    {
//        array_key_exists('socks4', $this->inputs) ? $this->socks4 = $this->trim($this->inputs['socks4']) : $this->socks4 = DEFAULT!!!;
//        array_key_exists('socks5', $this->inputs) ? $this->socks5 = $this->trim($this->inputs['socks5']) : $this->socks5 = [];
//        array_key_exists('https', $this->inputs) ? $this->https = $this->trim($this->inputs['https']) : $this->https = [];
    }

    public function trim($file)
    {
        return file($file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    }

    public function getParseParameters()
    {
        foreach ($this->inputs as $key => $input) {
            echo ('<br>' . $key . ': ' . $input);
        }
    }

    public function mkdirTemp()
    {
        if (!file_exists('storage/temp/')) {
            mkdir('storage/temp/', 0666, TRUE);
        }
    }

    public function getInputs($inputs)
    {
        $this->inputs = $inputs;
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

    public function node($xpath, $paths)
    {
        foreach ($paths as $path) {
            $nodeList = $xpath->query($path);

            foreach ($nodeList as $node) {
                $value = trim($node->nodeValue);
                $results[] = $value;
            }
        }
        return $results;
    }

    public function writeTeestoreResult($sizes, $i, $status, $buy, $link, $mfr, $title, $category, $price, $cy, $img, $description, $cond, $country, $fp)
    {
        foreach ($sizes as $size) {

            $result = [];

            $result[] = $i;
            $result[] = $status;
            $result[] = $buy;
            $result[] = $link;
            $result[] = $mfr;
            $result[] = $title;
            $result[] = $category;
            $result[] = $price;
            $result[] = $cy;
            $result[] = $img;
            $result[] = $description;
            $result[] = $size;
            $result[] = $cond;
            $result[] = $country;

            $string = implode(';', $result);
            //dd($string);

            fwrite($fp, $string . PHP_EOL);

            echo $i . ' - ' . $link . ' - OK!! <br>';
            $i++;
            ob_flush();
            flush();
        }
        return $i;
    }

    public function mb_ucfirst($word)
    {
        return mb_strtoupper(mb_substr($word, 0, 1, 'UTF-8'), 'UTF-8') . mb_substr(mb_convert_case($word, MB_CASE_LOWER, 'UTF-8'), 1, mb_strlen($word), 'UTF-8');
    }

    public function getTeestoreCardInfo()
    {
        $links = $this->trim('storage/temp/links_teestore_part2.txt');
        //dd($links);
//        $delimiter = ';';
        $status = 'В наличии';
        $buy = 'Нельзя';
        $mfr = 'teestore';
        $cat_man = 'Мужские футболки и майки';
        $cat_woman = 'Женские футболки и майки';
        $type_man = 'Мужская футболка ';
        $type_woman = 'Женская футболка ';
        $cy = 'RUR';
//        $desc = 'Мужская футболка с авторским принтом' . $title . '. Футболка сшивается вручную из выококачесвтенной ткани на основе хлопка с небольшим добавлением полиэстера, благодаря которому принт не выстирывается даже после 500 стирок. Ткань легкая и дышащая, без неприятного ощущения синтетики.';
        $cond = 'Необходима предоплата';
        $country = 'Россия';


        $fp = fopen('storage/temp/result_teestore.txt', "wb");
        $bad_fp = fopen('storage/temp/bad_result_teestore.txt', "ab");
        $i = 1;

        foreach ($links as $link) {
            $data = $this->getRealData($link);
//            dd($links[1]);
            $link_exp = explode('/', $link);
//            dd($link_exp);

            if ($data) {

                $dom = new DOMDocument;    //создаем объект
                $dom->loadHTML($data, LIBXML_NOERROR);
                $xpath = new DomXPath($dom);
                $paths = [];
                $paths[] = ".//h1";
                $paths[] = ".//a[@class='breadcrumb'][last()]";
                $paths[] = ".//div[@class='view_good']/img/@src";
                $desc_1 = 'с авторским принтом ';
                $desc_2 = ' сшивается вручную из выококачесвтенной ткани на основе хлопка с небольшим добавлением полиэстера, благодаря которому принт не выстирывается даже после 500 стирок. Ткань легкая и дышащая, без неприятного ощущения синтетики.';


                if (in_array('m_tee', $link_exp)) {
                    $sizes = ['XS', 'S', 'M', 'L', 'XL', '2XL', '3XL', '4XL', '5XL',];
                    $price = 1290;
                    $type = 'Мужская футболка ';
                    $result = $this->node($xpath, $paths);
                    $result_name = explode(' ', $result[0]);
                    $out = array_slice($result_name, 1);
                    $name = implode(' ', $out);
                    $img = $result[2];
                    $title = $type . $result[1] . ' ' . $name;
                    $description = $type . $desc_1 . $name . '. ' . $result_name[0] . $desc_2;
                    $i = $this->writeTeestoreResult($sizes, $i, $status, $buy, $link, $mfr, $title, $cat_man, $price, $cy, $img, $description, $cond, $country, $fp);
                } elseif (in_array('m_tan', $link_exp)) {
                    $sizes = ['XS', 'S', 'M', 'L', 'XL', '2XL', '3XL',];
                    $price = 990;
                    $type = 'Мужская майка ';
                    $result = $this->node($xpath, $paths);
                    $result_name = explode(' ', $result[0]);
                    $out = array_slice($result_name, 1);
                    $name = implode(' ', $out);
                    $img = $result[2];
                    $title = $type . $result[1] . ' ' . $name;
                    $description = $type . $desc_1 . $name . '. ' . $result_name[0] . $desc_2;
                    $i = $this->writeTeestoreResult($sizes, $i, $status, $buy, $link, $mfr, $title, $cat_man, $price, $cy, $img, $description, $cond, $country, $fp);
                } elseif (in_array('m_lon', $link_exp)) {
                    $sizes = ['XS', 'S', 'M', 'L', 'XL', '2XL', '3XL', '4XL', '5XL',];
                    $price = 1590;
                    $type = 'Мужской лонгслив ';
                    $result = $this->node($xpath, $paths);
                    $result_name = explode(' ', $result[0]);
                    $out = array_slice($result_name, 1);
                    $name = implode(' ', $out);
                    $img = $result[2];
                    $title = $type . $result[1] . ' ' . $name;
                    $description = $type . $desc_1 . $name . '. ' . $result_name[0] . $desc_2;
                    $i = $this->writeTeestoreResult($sizes, $i, $status, $buy, $link, $mfr, $title, $cat_man, $price, $cy, $img, $description, $cond, $country, $fp);
                } elseif (in_array('m_rag', $link_exp)) {
                    $sizes = ['XS', 'S', 'M', 'L', 'XL', '2XL', '3XL',];
                    $price = 1490;
                    $type = 'Мужской реглан ';
                    $result = $this->node($xpath, $paths);
                    $result_name = explode(' ', $result[0]);
                    $out = array_slice($result_name, 1);
                    $name = implode(' ', $out);
                    $img = $result[2];
                    $title = $type . $result[1] . ' ' . $name;
                    $description = $type . $desc_1 . $name . '. ' . $result_name[0] . $desc_2;
                    $i = $this->writeTeestoreResult($sizes, $i, $status, $buy, $link, $mfr, $title, $cat_man, $price, $cy, $img, $description, $cond, $country, $fp);
                } elseif (in_array('w_tee', $link_exp)) {
                    $sizes = ['XS', 'S', 'M', 'L', 'XL', '2XL', '3XL',];
                    $price = 1290;
                    $type = 'Женская футболка ';
                    $result = $this->node($xpath, $paths);
                    $result_name = explode(' ', $result[0]);
                    $out = array_slice($result_name, 2);
                    $name = implode(' ', $out);
                    $img = $result[2];
                    $title = $type . $result[1] . ' ' . $name;
                    $description = $type . $desc_1 . $name . '. ' . $this->mb_ucfirst($result_name[1]) . $desc_2;
                    $i = $this->writeTeestoreResult($sizes, $i, $status, $buy, $link, $mfr, $title, $cat_woman, $price, $cy, $img, $description, $cond, $country, $fp);
                } elseif (in_array('w_tan', $link_exp)) {
                    $sizes = ['XS', 'S', 'M', 'L', 'XL', '2XL',];
                    $price = 990;
                    $type = 'Женская майка ';
                    $result = $this->node($xpath, $paths);
                    $result_name = explode(' ', $result[0]);
                    $out = array_slice($result_name, 2);
                    $name = implode(' ', $out);
                    $img = $result[2];
                    $title = $type . $result[1] . ' ' . $name;
                    $description = $type . $desc_1 . $name . '. ' . $this->mb_ucfirst($result_name[1]) . $desc_2;
                    $i = $this->writeTeestoreResult($sizes, $i, $status, $buy, $link, $mfr, $title, $cat_woman, $price, $cy, $img, $description, $cond, $country, $fp);
                } elseif (in_array('w_lon', $link_exp)) {
                    $sizes = ['XS', 'S', 'M', 'L', 'XL', '2XL', '3XL',];
                    $price = 1590;
                    $type = 'Женский лонгслив ';
                    $result = $this->node($xpath, $paths);
                    $result_name = explode(' ', $result[0]);
                    $out = array_slice($result_name, 2);
                    $name = implode(' ', $out);
                    $img = $result[2];
                    $title = $type . $result[1] . ' ' . $name;
                    $description = $type . $desc_1 . $name . '. ' . $this->mb_ucfirst($result_name[1]) . $desc_2;
                    $i = $this->writeTeestoreResult($sizes, $i, $status, $buy, $link, $mfr, $title, $cat_woman, $price, $cy, $img, $description, $cond, $country, $fp);
                } elseif (in_array('w_rag', $link_exp)) {
                    $sizes = ['XS', 'S', 'M', 'L', 'XL', '2XL',];
                    $price = 1490;
                    $type = 'Женский реглан ';
                    $result = $this->node($xpath, $paths);
                    $result_name = explode(' ', $result[0]);
                    $out = array_slice($result_name, 2);
                    $name = implode(' ', $out);
                    $img = $result[2];
                    $title = $type . $result[1] . ' ' . $name;
                    $description = $type . $desc_1 . $name . '. ' . $this->mb_ucfirst($result_name[1]) . $desc_2;
                    $i = $this->writeTeestoreResult($sizes, $i, $status, $buy, $link, $mfr, $title, $cat_woman, $price, $cy, $img, $description, $cond, $country, $fp);
                } else {
                    echo 'Нет такого типа футболки!! <br>';
                    fwrite($bad_fp, $link . ' - Нет такого типа футболки' . PHP_EOL);
                    ob_flush();
                    flush();
                }

//                $i++;
                //dd($name);
//                foreach ($paths as $key => $path) {
//                    $nodeList = $xpath->query($path);
//
//                    foreach ($nodeList as $node) {
//                        
//                    }
//                }
//
//
//                //$nodeList = $xpath->query($title);
//                foreach ($nodeList as $node) {
//                    // добавляем это чтото в массив в нужный ключ
//                    $value = trim($node->nodeValue);
//                    $val = explode(' ', $value);
//
//                    //dd(!in_array($link, $results));
//
//
//
//                    $results[] = $value;
//                    // fwrite($fp, $link . PHP_EOL);
//                    //dd($link);
//                }
//                dd($val);
//
//                if (count($xpath->query($error)) == 0) {
//                    $nodeList = $xpath->query($path);
//                    if (count($nodeList) > 0) {
//
//                        foreach ($nodeList as $node) {
//                            // добавляем это чтото в массив в нужный ключ
//                            $link = mb_strtolower(trim($node->nodeValue));
//                            //dd(!in_array($link, $results));
//
//                            if (!in_array($link, $results)) {
//                                $results[] = $link;
//                                fwrite($fp, $link . PHP_EOL);
//                            }
//                            //dd($link);
//                        }
//                        echo $url . ' OK <br>';
//
////                        dd($results);
//                    } else {
//                        echo $url . 'Нет ссылок <br>';
//                        fwrite($bad_fp, $url . ' - Нет ссылок' . PHP_EOL);
//                    }
//                    //dd($nodeList);
//                } else {
//                    echo $url . 'Ошибка 404 <br>';
//                    fwrite($bad_fp, $url . ' - Ошибка 404' . PHP_EOL);
//                }
            }

            //usleep(5000000);
        }
        echo '!!!END SUCCESS!!!';
        fclose($fp);
        fclose($bad_fp);
    }

    public function getTeestoreCardLink()
    {
//        $arr = [
//            'a', 'b', 'c', 'c', 'c', 'e', 'a'
//        ];
//        $result = array_unique($arr);
//        dd($result);
        $fp = fopen('storage/temp/links_teestore_part2.txt', "ab");
        $bad_fp = fopen('storage/temp/bad_links_teestore.txt', "ab");

        $results = $this->trim('storage/temp/links_teestore_part2.txt');
        //dd($results);
        foreach ($this->urls as $url) {
            $data = $this->getRealData($url);

            if ($data) {

                $dom = new DOMDocument;    //создаем объект
                $dom->loadHTML($data, LIBXML_NOERROR);
                $xpath = new DomXPath($dom);
                $path = ".//div[@class='types']/a/@href";
                $error = ".//div[@class='p404']";

                if (count($xpath->query($error)) == 0) {
                    $nodeList = $xpath->query($path);
                    if (count($nodeList) > 0) {

                        foreach ($nodeList as $node) {
                            // добавляем это чтото в массив в нужный ключ
                            $link = mb_strtolower(trim($node->nodeValue));
                            //dd(!in_array($link, $results));

                            if (!in_array($link, $results)) {
                                $results[] = $link;
                                fwrite($fp, $link . PHP_EOL);
                            }
                            //dd($link);
                        }
                        echo $url . ' OK <br>';

//                        dd($results);
                    } else {
                        echo $url . 'Нет ссылок <br>';
                        fwrite($bad_fp, $url . ' - Нет ссылок' . PHP_EOL);
                    }
                    //dd($nodeList);
                } else {
                    echo $url . 'Ошибка 404 <br>';
                    fwrite($bad_fp, $url . ' - Ошибка 404' . PHP_EOL);
                }
            }
            ob_flush();
            flush();
            //usleep(5000000);
        }
        echo '!!!END SUCCESS!!!';
        fclose($fp);
        fclose($bad_fp);
        //dd($results);
    }

    public function getRealMultiData($urls)
    {
        $mh = curl_multi_init();
        $handles = [];

        foreach ($urls as $url) {
            $ch = curl_init($url);

            $user_agents = [
                'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/66.0.3359.181 Safari/537.36', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:60.0) Gecko/20100101 Firefox/60.0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_13_4) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/66.0.3359.181 Safari/537.36', 'Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/66.0.3359.181 Safari/537.36', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/67.0.3396.87 Safari/537.36', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_13_4) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/11.1 Safari/605.1.15', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) HeadlessChrome/64.0.3282.119 Safari/537.36', 'Mozilla/5.0 (Windows NT 6.1; Win64; x64; rv:60.0) Gecko/20100101 Firefox/60.0', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:60.0) Gecko/20100101 Firefox/60.0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.13; rv:60.0) Gecko/20100101 Firefox/60.0', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/67.0.3396.79 Safari/537.36', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_13_5) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/11.1.1 Safari/605.1.15', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_12_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/66.0.3359.181 Safari/537.36', 'Mozilla/5.0 (X11; Linux x86_64; rv:60.0) Gecko/20100101 Firefox/60.0', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/67.0.3396.62 Safari/537.36', 'Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/67.0.3396.87 Safari/537.36', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/64.0.3282.140 Safari/537.36 Edge/17.17134', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/66.0.3359.139 Safari/537.36', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/66.0.3359.181 Safari/537.36', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_13_5) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/67.0.3396.87 Safari/537.36', 'Mozilla/5.0 (Windows NT 6.3; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/66.0.3359.181 Safari/537.36', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/58.0.3029.110 Safari/537.36 Edge/16.16299', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_13_3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/66.0.3359.181 Safari/537.36', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_11_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/66.0.3359.181 Safari/537.36', 'Mozilla/5.0 (Windows NT 6.1; WOW64; Trident/7.0; rv:11.0) like Gecko', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_13_4) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/66.0.3359.139 Safari/537.36', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_13_5) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/66.0.3359.181 Safari/537.36', 'Mozilla/5.0 (X11; Linux x86_64; rv:52.0) Gecko/20100101 Firefox/52.0', 'Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/66.0.3359.181 Safari/537.36', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/67.0.3396.62 Safari/537.36', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_12_6) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/11.1 Safari/605.1.15', 'Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/67.0.3396.79 Safari/537.36', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_13_4) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/67.0.3396.79 Safari/537.36', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_13_4) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/67.0.3396.87 Safari/537.36', 'Mozilla/5.0 (Windows NT 10.0; WOW64; Trident/7.0; rv:11.0) like Gecko', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_13_3) AppleWebKit/604.5.6 (KHTML, like Gecko) Version/11.0.3 Safari/604.5.6', 'Mozilla/5.0 (Windows NT 6.3; Win64; x64; rv:60.0) Gecko/20100101 Firefox/60.0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.12; rv:60.0) Gecko/20100101 Firefox/60.0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_12_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/67.0.3396.87 Safari/537.36', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_13_4) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/67.0.3396.62 Safari/537.36', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:59.0) Gecko/20100101 Firefox/59.0', 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/66.0.3359.181 Safari/537.36', 'Mozilla/5.0 (Windows NT 6.1; Win64; x64; rv:59.0) Gecko/20100101 Firefox/59.0', 'Mozilla/5.0 (compatible; MSIE 9.0; Windows NT 6.1; Trident/5.0;  Trident/5.0)', 'Mozilla/5.0 (iPad; CPU OS 11_3 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/11.0 Mobile/15E148 Safari/604.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:61.0) Gecko/20100101 Firefox/61.0', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/51.0.2704.106 Safari/537.36', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/66.0.3359.170 Safari/537.36 OPR/53.0.2907.68', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/66.0.3359.181 Chrome/66.0.3359.181 Safari/537.36', 'Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/67.0.3396.62 Safari/537.36', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/65.0.3325.181 Safari/537.36', 'Mozilla/5.0 (Windows NT 6.1; rv:52.0) Gecko/20100101 Firefox/52.0', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/67.0.3396.87 Safari/537.36', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_13_5) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/67.0.3396.79 Safari/537.36', 'Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/66.0.3359.139 Safari/537.36', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/67.0.3396.79 Safari/537.36', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/66.0.3359.139 Safari/537.36', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.11; rv:60.0) Gecko/20100101 Firefox/60.0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_12_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/66.0.3359.139 Safari/537.36', 'Mozilla/5.0 (Windows NT 10.0; WOW64; rv:60.0) Gecko/20100101 Firefox/60.0', 'Mozilla/5.0 (Windows NT 6.1; rv:60.0) Gecko/20100101 Firefox/60.0', 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:52.0) Gecko/20100101 Firefox/52.0', 'Mozilla/5.0 (compatible; MSIE 9.0; Windows NT 6.0; Trident/5.0;  Trident/5.0)', 'Mozilla/5.0 (iPad; CPU OS 11_4 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/11.0 Mobile/15E148 Safari/604.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_13_2) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/66.0.3359.181 Safari/537.36', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/65.0.3325.181 Safari/537.36', 'Mozilla/5.0 (Windows NT 6.3; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/67.0.3396.87 Safari/537.36', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:59.0) Gecko/20100101 Firefox/59.0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_12_6) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/11.1.1 Safari/605.1.15', 'Mozilla/5.0 (Windows NT 6.1; Win64; x64; rv:61.0) Gecko/20100101 Firefox/61.0', 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:60.0) Gecko/20100101 Firefox/60.0', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36 Edge/15.15063', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/66.0.3359.181 Safari/537.36', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_11_6) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/11.1 Safari/605.1.15', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_11_6) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/11.1.1 Safari/605.1.15', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:57.0) Gecko/20100101 Firefox/57.0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_11_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/67.0.3396.87 Safari/537.36', 'Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/67.0.3396.87 Safari/537.36', 'Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/65.0.3325.181 Safari/537.36', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/66.0.3359.117 Safari/537.36', 'Mozilla/5.0 (X11; Linux x86_64; rv:61.0) Gecko/20100101 Firefox/61.0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.13; rv:59.0) Gecko/20100101 Firefox/59.0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_13_5) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/67.0.3396.62 Safari/537.36', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/63.0.3239.132 Safari/537.36', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/66.0.3359.170 Safari/537.36', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/66.0.3359.170 Safari/537.36',
            ];
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

    public function getRealData($url)
    {
//        $url = 'https://teestore.ru/m_tee/1';

        $this->socks4 = $this->trim('storage/temp/good_socks4.txt');
        $user_agents = [
            'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/66.0.3359.181 Safari/537.36', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:60.0) Gecko/20100101 Firefox/60.0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_13_4) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/66.0.3359.181 Safari/537.36', 'Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/66.0.3359.181 Safari/537.36', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/67.0.3396.87 Safari/537.36', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_13_4) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/11.1 Safari/605.1.15', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) HeadlessChrome/64.0.3282.119 Safari/537.36', 'Mozilla/5.0 (Windows NT 6.1; Win64; x64; rv:60.0) Gecko/20100101 Firefox/60.0', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:60.0) Gecko/20100101 Firefox/60.0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.13; rv:60.0) Gecko/20100101 Firefox/60.0', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/67.0.3396.79 Safari/537.36', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_13_5) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/11.1.1 Safari/605.1.15', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_12_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/66.0.3359.181 Safari/537.36', 'Mozilla/5.0 (X11; Linux x86_64; rv:60.0) Gecko/20100101 Firefox/60.0', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/67.0.3396.62 Safari/537.36', 'Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/67.0.3396.87 Safari/537.36', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/64.0.3282.140 Safari/537.36 Edge/17.17134', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/66.0.3359.139 Safari/537.36', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/66.0.3359.181 Safari/537.36', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_13_5) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/67.0.3396.87 Safari/537.36', 'Mozilla/5.0 (Windows NT 6.3; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/66.0.3359.181 Safari/537.36', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/58.0.3029.110 Safari/537.36 Edge/16.16299', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_13_3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/66.0.3359.181 Safari/537.36', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_11_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/66.0.3359.181 Safari/537.36', 'Mozilla/5.0 (Windows NT 6.1; WOW64; Trident/7.0; rv:11.0) like Gecko', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_13_4) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/66.0.3359.139 Safari/537.36', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_13_5) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/66.0.3359.181 Safari/537.36', 'Mozilla/5.0 (X11; Linux x86_64; rv:52.0) Gecko/20100101 Firefox/52.0', 'Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/66.0.3359.181 Safari/537.36', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/67.0.3396.62 Safari/537.36', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_12_6) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/11.1 Safari/605.1.15', 'Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/67.0.3396.79 Safari/537.36', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_13_4) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/67.0.3396.79 Safari/537.36', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_13_4) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/67.0.3396.87 Safari/537.36', 'Mozilla/5.0 (Windows NT 10.0; WOW64; Trident/7.0; rv:11.0) like Gecko', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_13_3) AppleWebKit/604.5.6 (KHTML, like Gecko) Version/11.0.3 Safari/604.5.6', 'Mozilla/5.0 (Windows NT 6.3; Win64; x64; rv:60.0) Gecko/20100101 Firefox/60.0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.12; rv:60.0) Gecko/20100101 Firefox/60.0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_12_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/67.0.3396.87 Safari/537.36', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_13_4) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/67.0.3396.62 Safari/537.36', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:59.0) Gecko/20100101 Firefox/59.0', 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/66.0.3359.181 Safari/537.36', 'Mozilla/5.0 (Windows NT 6.1; Win64; x64; rv:59.0) Gecko/20100101 Firefox/59.0', 'Mozilla/5.0 (compatible; MSIE 9.0; Windows NT 6.1; Trident/5.0;  Trident/5.0)', 'Mozilla/5.0 (iPad; CPU OS 11_3 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/11.0 Mobile/15E148 Safari/604.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:61.0) Gecko/20100101 Firefox/61.0', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/51.0.2704.106 Safari/537.36', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/66.0.3359.170 Safari/537.36 OPR/53.0.2907.68', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/66.0.3359.181 Chrome/66.0.3359.181 Safari/537.36', 'Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/67.0.3396.62 Safari/537.36', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/65.0.3325.181 Safari/537.36', 'Mozilla/5.0 (Windows NT 6.1; rv:52.0) Gecko/20100101 Firefox/52.0', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/67.0.3396.87 Safari/537.36', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_13_5) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/67.0.3396.79 Safari/537.36', 'Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/66.0.3359.139 Safari/537.36', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/67.0.3396.79 Safari/537.36', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/66.0.3359.139 Safari/537.36', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.11; rv:60.0) Gecko/20100101 Firefox/60.0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_12_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/66.0.3359.139 Safari/537.36', 'Mozilla/5.0 (Windows NT 10.0; WOW64; rv:60.0) Gecko/20100101 Firefox/60.0', 'Mozilla/5.0 (Windows NT 6.1; rv:60.0) Gecko/20100101 Firefox/60.0', 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:52.0) Gecko/20100101 Firefox/52.0', 'Mozilla/5.0 (compatible; MSIE 9.0; Windows NT 6.0; Trident/5.0;  Trident/5.0)', 'Mozilla/5.0 (iPad; CPU OS 11_4 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/11.0 Mobile/15E148 Safari/604.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_13_2) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/66.0.3359.181 Safari/537.36', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/65.0.3325.181 Safari/537.36', 'Mozilla/5.0 (Windows NT 6.3; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/67.0.3396.87 Safari/537.36', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:59.0) Gecko/20100101 Firefox/59.0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_12_6) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/11.1.1 Safari/605.1.15', 'Mozilla/5.0 (Windows NT 6.1; Win64; x64; rv:61.0) Gecko/20100101 Firefox/61.0', 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:60.0) Gecko/20100101 Firefox/60.0', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36 Edge/15.15063', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/66.0.3359.181 Safari/537.36', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_11_6) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/11.1 Safari/605.1.15', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_11_6) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/11.1.1 Safari/605.1.15', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:57.0) Gecko/20100101 Firefox/57.0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_11_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/67.0.3396.87 Safari/537.36', 'Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/67.0.3396.87 Safari/537.36', 'Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/65.0.3325.181 Safari/537.36', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/66.0.3359.117 Safari/537.36', 'Mozilla/5.0 (X11; Linux x86_64; rv:61.0) Gecko/20100101 Firefox/61.0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.13; rv:59.0) Gecko/20100101 Firefox/59.0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_13_5) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/67.0.3396.62 Safari/537.36', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/63.0.3239.132 Safari/537.36', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/66.0.3359.170 Safari/537.36', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/66.0.3359.170 Safari/537.36',
        ];

        $proxies = [
            '194.186.230.226:1080', '85.143.177.150:1080', '85.142.251.28:1080', '85.143.160.45:1080', '217.195.74.17:1080', '217.67.189.202:1080', '46.150.167.173:1080', '185.35.117.102:5070', '81.211.18.10:1080', '85.143.156.238:1080', '95.31.16.215:9999', '195.218.131.226:1080', '77.87.215.81:1080', '195.16.49.18:1080', '188.187.62.254:1080', '86.62.127.232:1080', '128.70.54.4:1080', '217.144.101.227:1080', '81.211.100.158:1080', '195.218.167.90:1080', '81.211.31.58:1080', '188.35.138.138:1080', '5.56.138.16:1080', '195.144.232.165:1080', '77.51.183.143:1080', '31.7.225.31:1080', '80.244.237.22:5555', '194.67.6.98:1080', '92.55.54.126:1080', '128.74.129.24:1080', '92.39.129.110:3128', '195.218.197.194:1080', '128.75.212.150:1080', '81.89.71.70:41443', '194.186.252.74:1080', '91.224.133.121:35618', '95.79.107.205:1080', '81.163.68.127:41538', '128.73.49.3:1080', '88.85.172.30:1080', '5.166.179.82:1080', '188.134.1.20:63756', '195.218.138.150:1080', '81.30.215.23:1080', '46.191.159.180:1080',
        ];

        //$steps = count($proxies);
        $i = 0;
        $try = TRUE;

        while ($try) {

            $cookiefile = 'storage/temp/cookie2.txt';
            $proxy = $this->socks4[mt_rand(0, count($proxies) - 1)];
            $user_agent = $user_agents[mt_rand(0, count($user_agents) - 1)];
            //($proxies[$i]) ? $proxies[$i] : null;

            $headers = [
                'Accept: text/xml,application/xml,application/xhtml+xml,text/html;q=0.9,text/plain;q=0.8,image/png,*/*;q=0.5',
                'Cache-Control: max-age=100',
                'Connection: keep-alive',
                'Keep-Alive: 300',
                'Accept-Charset: ISO-8859-1,utf-8;q=0.7,*;q=0.7',
                'X-Requested-With: XMLHttpRequest',
            ];

            $ch = curl_init($url);

            curl_setopt($ch, CURLOPT_USERAGENT, $user_agent);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLINFO_HEADER_OUT, true);
            //curl_setopt($ch, CURLOPT_REFERER, 'https://www.kinopoisk.ru/film/');
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
//            curl_setopt($ch, CURLOPT_COOKIEJAR, $cookiefile);
//            curl_setopt($ch, CURLOPT_COOKIEFILE, $cookiefile);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_HEADER, 0);
            curl_setopt($ch, CURLOPT_TIMEOUT, 15);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
//            curl_setopt($ch, CURLOPT_PROXY, $proxy);
//            curl_setopt($ch, CURLOPT_HTTPPROXYTUNNEL, True);
//            curl_setopt($ch, CURLOPT_PROXYTYPE, CURLPROXY_SOCKS4);

            $data = curl_exec($ch);
            $http_code = curl_getinfo($ch, CURLINFO_RESPONSE_CODE);
            $strlen_data = strlen($data);

            curl_close($ch);

            //$i++;
            $try = (($http_code != 200) && ($strlen_data == 0));
            //($i < $steps)
            //var_dump($data);
        }
        return $data;
    }

    public function socks5($ip, $port)
    {
        $socks = @fsockopen($ip, $port, $errno, $errstr = '', 1);

        if ($socks) {
            $query = pack("C3", 5, 1, 0);
            fwrite($socks, $query);
            stream_set_timeout($socks, 1);
            $answer = fread($socks, 8192);
            if (strlen($answer) != 0) {
                $array = unpack("Cvn/Ccd", $answer);
                if (count($array) && $array['vn'] == 5) {
                    echo 'OK!<br>';
                    return TRUE;
                } else {
                    echo 'VN: ' . $array['vn'] . '<br>';
                }
            } else {
                echo 'Bad PROXY!!<br>';
            }
        } else {
            echo 'Bad PROXY!!<br>';
            return FALSE;
        }
    }

    public function socks4($ip, $port, $host = 'yandex.ru', $pport = 80)
    {

        $socks = @fsockopen($ip, $port, $errno, $errstr = '', 1);

        if ($socks) {
            $query = pack("C2", 4, 1);
            $query .= pack("n", $pport);
            $query .= $this->_host2int($host);
            $query .= pack("C", 0);

            fwrite($socks, $query);
            stream_set_timeout($socks, 1);
            $answer = fread($socks, 8192);
            if (strlen($answer) != 0) {
                $array = unpack("Cvn/Ccd", $answer);
                if (count($array) && $array['cd'] == 90) {
                    echo 'OK!<br>';
                    return TRUE;
                }
            }
        } else {
            echo 'Bad PROXY!!<br>';
            return FALSE;
        }
    }

}
