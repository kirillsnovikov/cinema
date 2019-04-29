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

        while ($try) {
            $ch = $this->curl->curlInit($url);

            $result = $this->curl->setDefaultCurlOptions($ch)
                    ->setCookieFile($ch)
                    ->setRandomRefererFromFile($ch)
                    ->setUserAgent($ch)
//                    ->setHeaders($ch)
                    ->getCurlExec($ch);

            if (empty($result['data']) || $result['response_code'] != 200 || $result['strlen_data'] < 10 || $result['err_num'] != 0 || !empty($result['err_msg'])) {
                $try = true;
            } else {
                return $result['data'];
            }
        }
    }

}
