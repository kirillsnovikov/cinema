<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Services\Kinoparser;

use App\Contracts\Kinoparser\DataGetterInterface;

/**
 * Description of CurlKinopoiskDefault
 *
 * @author Кирилл
 */
class CurlKinopoiskDefault extends CurlBase implements DataGetterInterface
{

    /**
     * 
     * @param string $url
     * @return string
     */
    public function getData(string $url): string
    {
        $try = true;

        while ($try) {
            $ch = $this->curlInit($url);

            $result = $this->setDefaultCurlOptions($ch)
                    ->setCookieFile($ch)
                    ->setReferer($ch, 'https://www.kinopoisk.ru/')
                    ->getCurlExec($ch);

            if (empty($result['data']) || $result['response_code'] != 200 || $result['strlen_data'] < 10 || $result['err_num'] != 0 || !empty($result['err_msg'])) {
                $try = true;
            } else {
                return $result['data'];
            }
        }
    }

}
