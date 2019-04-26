<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Services\Kinoparser\Curl;

use App\Contracts\Kinoparser\HeadersGetterInterface;
use App\Contracts\Kinoparser\ReferersGetterInterface;
use App\Contracts\Kinoparser\UserAgentsGetterInterface;

/**
 * Description of BaseCurl
 *
 * @author Кирилл
 */
class BaseCurl
{

    /**
     * @var HeadersGetterInterface
     */
    private $headers;

    /**
     * @var UserAgentsGetterInterface
     */
    private $user_agents;

    /**
     * @var ReferersGetterInterface
     */
    private $referers;

    public function __construct(ReferersGetterInterface $referers, UserAgentsGetterInterface $user_agents, HeadersGetterInterface $headers)
    {


        $this->referers = $referers;
        $this->user_agents = $user_agents;
        $this->headers = $headers;
    }

    /**
     * 
     * @param type $ch
     * @return array
     */
    public function getCurlExec($ch): array
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
    public function setDefaultCurlOptions($ch)
    {
        dd(__DIR__.'/../config');
        $fOut = fopen($_SERVER["DOCUMENT_ROOT"].'/'.'curl_out.txt', "w" );
//        curl_setopt($ch, CURLOPT_HEADER, true);
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
    public function setCookieFile($ch, string $cookiefile = __DIR__ . '/config/cookie.txt')
    {
        curl_setopt($ch, CURLOPT_COOKIEJAR, $cookiefile);
        curl_setopt($ch, CURLOPT_COOKIEFILE, $cookiefile);
        return $this;
    }

    /**
     * 
     * @param type $ch
     * @param string $referer
     * @return $this
     */
    public function setReferer($ch, string $referer)
    {
        curl_setopt($ch, CURLOPT_REFERER, $referer);
        return $this;
    }

    /**
     * 
     * @param type $ch
     * @return $this
     */
    public function setRandomRefererFromFile($ch)
    {
        $referer = $this->referers->getReferers();
        return $this->setReferer($ch, $referer);
    }

    /**
     * 
     * @param type $ch
     * @return $this
     */
    public function setUserAgent($ch)
    {
        $user_agent = $this->user_agents->getUserAgents();
        curl_setopt($ch, CURLOPT_USERAGENT, $user_agent);
        return $this;
    }

    /**
     * 
     * @param type $ch
     * @return $this
     */
    public function setHeaders($ch)
    {
        $headers = $this->headers->getHeaders();
        dd($headers);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        return $this;
    }

    /**
     * 
     * @param type $url
     * @return type
     */
    public function curlInit($url)
    {
        $ch = curl_init($url);
        return $ch;
    }

}
