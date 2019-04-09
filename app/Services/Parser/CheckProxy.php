<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Services\Parser;

/**
 * Description of CheckProxy
 *
 * @author KNovikov
 */
class CheckProxy
{

    public function checkProxies()
    {
        $this->mkdirTemp();

        if (array_key_exists('socks4', $this->inputs)) {
            $this->socks4 = $this->fileToArray($this->inputs['socks4']);
            $fp = fopen('storage/temp/good_socks4.txt', 'wb');
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
            $this->socks5 = $this->fileToArray($this->inputs['socks5']);
            $fp = fopen('storage/temp/good_socks5.txt', 'wb');
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

    public function socks5($ip, $port)
    {
        $socks = @fsockopen($ip, $port, $errno, $errstr = '', 1);

        if ($socks) {
            $query = pack("C3", 5, 1, 0);
            \fwrite($socks, $query);
            stream_set_timeout($socks, 1);
            $answer = \fread($socks, 8192);
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

    public function socks4($ip, $port, $host = 'kinopoisk.ru', $pport = 80)
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
