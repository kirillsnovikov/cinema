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

    protected function getCurlExec($ch): array
    {


        $data = curl_exec($ch);
        curl_close($ch);
//        dd(curl_getinfo($ch, CURLINFO_COOKIELIST));
        dd($data);
        return $data;
    }

    private function setCookie($ch)
    {
        
    }

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

//        dd($ch);

        return $this;
    }

    protected function setCookieFile($ch, $cookiefile = __DIR__ . '/config/cookie.txt')
    {

        curl_setopt($ch, CURLOPT_COOKIEJAR, $cookiefile);
        curl_setopt($ch, CURLOPT_COOKIEFILE, $cookiefile);

//        curl_setopt($ch, CURLOPT_COOKIEFILE, "");
//        curl_getinfo($ch, CURLINFO_COOKIELIST);
        return $this;
    }

    protected function curlInit($url)
    {
        $ch = curl_init($url);
//        dd($ch);
        return $ch;
    }

    protected function setCurlOptions()
    {
        
    }

}
