<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Services\Kinoparser;

use Illuminate\Http\Request;

/**
 * Description of CurlBase
 *
 * @author Кирилл
 */
abstract class CurlBase
{

    /**
     * @var Request
     */
    private $request;

    public function __construct(Request $request)
    {

        $this->request = $request;
    }

    /**
     * 
     * @param type $ch
     * @return array
     */
    protected function getCurlExec($ch): array
    {
        $result = [];
        $data = curl_exec($ch);

        $result['data'] = $data;
        $result['response_code'] = curl_getinfo($ch, CURLINFO_RESPONSE_CODE);
        $result['strlen_data'] = strlen($data);
        $result['err_num'] = curl_errno($ch);
        $result['err_msg'] = curl_error($ch);

        curl_close($ch);
        return $result;
    }

    /**
     * 
     * @param type $ch
     * @return $this
     */
    protected function setDefaultCurlOptions($ch)
    {
        curl_setopt($ch, CURLOPT_HEADER, true);
        curl_setopt($ch, CURLOPT_ENCODING, "");
        curl_setopt($ch, CURLOPT_MAXREDIRS, 10);
        curl_setopt($ch, CURLOPT_TIMEOUT, 15);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 15);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);

        /**
         * CURLINFO_HEADER_OUT for read headers throw curl_getinfo()
         */
        curl_setopt($ch, CURLINFO_HEADER_OUT, true);

        /**
         * CURLOPT_FOLLOWLOCATION to redirect throw all Locations
         */
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);

        /**
         * TRUE to return the transfer as a string of the return value of curl_exec()
         * instead of outputting it directly.
         */
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        return $this;
    }

    /**
     * 
     * @param type $ch
     * @param string $cookiefile
     * @return $this
     */
    protected function setCookieFile($ch, string $cookiefile = __DIR__ . '/config/cookie.txt')
    {

        curl_setopt($ch, CURLOPT_COOKIEJAR, $cookiefile);
        curl_setopt($ch, CURLOPT_COOKIEFILE, $cookiefile);

//        curl_setopt($ch, CURLOPT_COOKIEFILE, "");
//        curl_getinfo($ch, CURLINFO_COOKIELIST);
        return $this;
    }

    /**
     * 
     * @param type $ch
     * @param string $referer
     * @return $this
     */
    protected function setReferer($ch, string $referer)
    {
        curl_setopt($ch, CURLOPT_REFERER, $referer);
        return $this;
    }

    /**
     * 
     * @param type $url
     * @return type
     */
    protected function curlInit($url)
    {
        $ch = curl_init($url);
        return $ch;
    }

}
