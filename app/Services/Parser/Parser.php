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
        $this->getKinopoiskMovieUrls();
        $this->checkProxies();


        //$this->socks5('91.235.7.7', 4145);
        //$this->socks4('88.210.57.22', 4145);
        //$_SERVER["HTTP_X_FORWARDED_FOR"];
        //$fp = $this->socks_connect('188.120.228.252', 32773, 'google.com', 80);
    }

    public function getKinopoiskMovieUrls()
    {

        $this->mkdirTemp();
//        if (!file_exists('storage/temp/')) {
//            mkdir('storage/temp/', 0666, TRUE);
//        }
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

    public function checkProxies()
    {
        ob_start();
        $this->getProxies();

//        if ($this->inputs['socks4'] === null && $this->inputs['socks5'] === null && $this->inputs['https'] === null) {
//            throw new ProxyException('Please load your proxy file');
//        }

        $this->mkdirTemp();

        if (array_key_exists('socks4', $this->inputs)) {
            $this->socks4 = $this->trim($this->inputs['socks4']);
            $fp = fopen('storage/temp/good_socks4.txt', "wb");
            $i = 1;
            $sum = count($this->socks4);
            foreach ($this->socks4 as $socks4) {
                echo $i . ' Socks4 from: ' . $sum . '<br>';
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
        }

        if (array_key_exists('socks5', $this->inputs)) {
            $this->socks5 = $this->trim($this->inputs['socks5']);
            $fp = fopen('storage/temp/good_socks5.txt', "wb");
            $i = 1;
            $sum = count($this->socks5);
            foreach ($this->socks5 as $socks5) {
                echo $i . ' Socks5 from: ' . $sum . '<br>';
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
        }
    }

    public function getProxies()
    {
//        array_key_exists('socks4', $this->inputs) ? $this->socks4 = $this->trim($this->inputs['socks4']) : $this->socks4 = NULL;
//        array_key_exists('socks5', $this->inputs) ? $this->socks5 = $this->trim($this->inputs['socks5']) : $this->socks5 = [];
//        array_key_exists('https', $this->inputs) ? $this->https = $this->trim($this->inputs['https']) : $this->https = [];
    }

    public function trim($file)
    {
        //$this->file = $this->getFile();
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

    public function socks_connect($host, $port, $dh, $dp) //адрес скоса, порт сокса, адрес сайта, порт сайта.
    {
        $result = true;
        $f = fsockopen($host, $port);
        if ($result) {
            $h = gethostbyname($dh);
            preg_match("#(\d+)\.(\d+)\.(\d+)\.(\d+)#", $h, $m);
            //dd($m);
            fwrite($f, '\x05\x01\x00\x01');
            //dd($f);
            dd($r = fread($f, 2));
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

    public function test(CheckProxy $check)
    {
        return $check;
    }

    public function sniff()
    {
        $request = 'https://ya.ru/';
        $timeout = 5;
        $sock = fsockopen('188.120.228.252', '32773', $error_number, $error_str, $timeout);
        fwrite($sock, $request);
        while (!feof($sock)) {
            echo fgets($sock, 1024);
        }
        fclose($sock);
        //Объявляем переменные даты, и переменные окружения
        $date = date('[D|d/m/Y|H:i]');

        $ip = getenv('Remote_addr');
        $methods = [
            'AUTH_TYPE',
            'CONTENT_LENGTH',
            'CONTENT_TYPE',
            'GATEWAY_INTERFACE',
            'PATH_INFO',
            'PATH_TRANSLATED',
            'QUERY_STRING',
            'REMOTE_ADDR',
            'REMOTE_HOST',
            'REMOTE_IDENT',
            'REMOTE_USER',
            'REQUEST_METHOD',
            'SCRIPT_NAME',
            'SERVER_NAME',
            'SERVER_PORT',
            'SERVER_PROTOCOL',
            'SERVER_SOFTWARE',
        ];
        foreach ($methods as $method) {
            $value[] = getenv($method);
        }
        $real_ip = getenv('HTTP_X_FORWARDED_FOR');

        $otkuda = getenv('HTTP_REFERER');

        $browser = getenv('HTTP_USER_AGENT');

        $win = getenv('windir');

        //$uid = implode($argv, '');
        dd($value);
//Открытие файла лога и запись в него данных,
//        закрытие лога
        $fp = fopen('log . txt', 'a');
        fputs($fp, '$date\t|$uid|\t$ip($real_ip)\t$browser\t$otkuda\t$win\n');
        fclose($fp);
//——-
//Печатаем рисунок,кстати может быть любой,даже из инета
        print (' <img src = "http://server.com/image.gif"> ');
    }

    public function socks5($ip, $port)
    {
        $socks = @fsockopen($ip, $port, $errno, $errstr = '', 3);
        //dd($socks);
        //dd($socks);
        //echo $socks;
        //Initiate the SOCKS handshake sequence.
        //Write our version an method to the server.
        //Version 5, 1 authentication method, no authentication. (For now)
        //$this->hex2bin('FF 01 00');
        if ($socks) {
            $query = pack("C3", 5, 1, 0);
            fwrite($socks, $query);
            $answer = fread($socks, 8192);
            if (strlen($answer) != 0) {
                $array = unpack("Cvn/Ccd", $answer);
                if (count($array) && $array['vn'] == 5) {
                    return TRUE;
                }
            }
        } else {
            return FALSE;
        }

        //dd($answer);
        //dd($pack);
        //dd($_SERVER['SERVER_PORT']);
        //Wait for a reply from the SOCKS server.
    }

    public function socks4($ip, $port, $host = 'yandex.ru', $pport = 80)
    {
//        $this->_host2int($host);
//        $start_time = microtime(true);
//        dd($start_time);
        $socks = @fsockopen($ip, $port, $errno, $errstr = '', 3);
//        dd($socks);
        if ($socks) {
            $query = pack("C2", 4, 1);
            $query .= pack("n", $pport);
            $query .= $this->_host2int($host);
            $query .= pack("C", 0);

            fwrite($socks, $query);
            $answer = fread($socks, 8192);
            if (strlen($answer) != 0) {
                $array = unpack("Cvn/Ccd", $answer);
                if (count($array) && $array['cd'] == 90) {
                    return TRUE;
                }
            }
        } else {
            return FALSE;
        }


//        $end_time = microtime(TRUE);
//        $check =  new CheckProxy;
//        
//        echo $check->str;
//        echo $end_time - $start_time;
//        if (!$socks) {
//            echo 'нет соединения!';
//            //dd($errstr);
//        } else {
//
//
//            dd(ord($status));
//            dd($status);
//        }
//        dd($query);
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

//    public function tcpServer()
//    {
//        error_reporting(E_ALL);
//
//        /* Позволяет скрипту ожидать соединения бесконечно. */
//        set_time_limit(0);
//
//        /* Включает скрытое очищение вывода так, что мы видим данные
//         * как только они появляются. */
//        ob_implicit_flush();
//
//        $address = '188.120.239.196';
//        $port = 12249;
//        $sock = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
//        socket_write($msgsock, $msg, strlen($msg))
////$socket_read = socket_read($sock, 100, PHP_BINARY_READ);
//        //dd(socket_bind($sock, '127.0.0.1'));
//
//        /* @var $sock type */
//        if ($sock === false) {
//            echo "Не удалось выполнить socket_create(): причина: " . socket_strerror(socket_last_error()) . "\n";
//        }
//
//        if (socket_bind($sock, '127.0.0.1') === false) {
//            echo "Не удалось выполнить socket_bind(): причина: " . socket_strerror(socket_last_error($sock)) . "\n";
//        }
//
//        if (socket_listen($sock, 5) === false) {
//            echo "Не удалось выполнить socket_listen(): причина: " . socket_strerror(socket_last_error($sock)) . "\n";
//        }
//
//
//
//        if (($msgsock = socket_accept($sock)) === false) {
//            echo "Не удалось выполнить socket_accept(): причина: " . socket_strerror(socket_last_error($sock)) . "\n";
//        }
//        /* Отправляем инструкции. */
//        $msg = "\nДобро пожаловать на тестовый сервер PHP. \n" .
//                "Чтобы отключиться, наберите 'выход'. Чтобы выключить сервер, наберите 'выключение'.\n";
//        dd(socket_write($msgsock, $msg, strlen($msg)));
//
//
//        if (false === ($buf = socket_read($msgsock, 2048, PHP_NORMAL_READ))) {
//            echo "Не удалось выполнить socket_read(): причина: " . socket_strerror(socket_last_error($msgsock)) . "\n";
//        }
//        if (!$buf = trim($buf)) {
//            
//        }
//        if ($buf == 'выход') {
//            
//        }
//        if ($buf == 'выключение') {
//            socket_close($msgsock);
//        }
//        $talkback = "PHP: Вы сказали '$buf'.\n";
//        socket_write($msgsock, $talkback, strlen($talkback));
//        echo "$buf\n";
//
//        socket_close($msgsock);
//
//
//        socket_close($sock);
//    }
}
