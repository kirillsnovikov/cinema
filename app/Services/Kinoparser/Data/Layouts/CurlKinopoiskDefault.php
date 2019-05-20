<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Services\Kinoparser\Data\Layouts;

use App\Contracts\Kinoparser\DataGetterInterface;
use App\Services\Kinoparser\Curl\BaseCurl;

/**
 * Description of CurlKinopoiskDefault
 *
 * @author Кирилл
 */
class CurlKinopoiskDefault implements DataGetterInterface
{

    /**
     * @var BaseCurl
     */
    private $curl;

    public function __construct(BaseCurl $curl)
    {

        $this->curl = $curl;
    }

    /**
     *
     * @param string $url
     * @return string
     */
    public function getData(string $url): string
    {
        $try = true;
        $fp = fopen(__DIR__ . '/../../config/errors.txt', 'ab');

        while ($try) {
            $ch = $this->curl->curlInit($url);

            $result = $this->curl->setDefaultCurlOptions($ch)
                    ->setCookieFile($ch)
                    ->setRandomRefererFromFile($ch)
                    ->setRandomUserAgentFromFile($ch)
//                    ->setUserAgent($ch)
                    ->setHeaders($ch)
                    ->getCurlExec($ch);

            usleep(mt_rand(50000, 100000));

            if (empty($result['data'])) {
                $try = true;
                fwrite($fp, $url . ' || Result data is empty string' . PHP_EOL);
            } elseif ($result['response_code'] != 200) {
                if ($result['response_code'] == 404) {
                    fwrite($fp, $url . ' || Response code == 404' . PHP_EOL);
                    fclose($fp);
                    return $result['data'];
                }
                $try = true;
                fwrite($fp, $url . ' || Response code != 200' . PHP_EOL);
            } elseif ($result['strlen_data'] < 10) {
                $try = true;
                fwrite($fp, $url . ' || String length < 10' . PHP_EOL);
            } elseif ($result['err_num'] != 0) {
                $try = true;
                fwrite($fp, $url . ' || Error number is ' . $result['err_num'] . PHP_EOL);
            } elseif (!empty($result['err_msg'])) {
                $try = true;
                fwrite($fp, $url . ' || Error message is ' . $result['err_msg'] . PHP_EOL);
            } elseif (preg_match('/captcha/', $result['data'], $options)) {
                $try = true;
                fwrite($fp, $url . ' || Captcha in result data ' . $options[0] . PHP_EOL);
            } else {
                fclose($fp);
                return $result['data'];
//                fwrite($fp, $url . ' || success! ' . PHP_EOL);
            }
        }
    }

}
