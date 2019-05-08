<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Services\Kinoparser\Options;

use App\Contracts\Kinoparser\ParserInterface;
use App\Services\Kinoparser\Curl\BaseCurl;
use App\Services\Kinoparser\Data\Layouts\CurlKinopoiskDefault;

/**
 * Description of ReferersSetterFromHotlog
 *
 * @author KNovikov
 */
class ReferersSetterFromHotlog
{

    /**
     * @var ParserInterface
     */
    private $parser;

    /**
     * @var CurlKinopoiskDefault
     */
    private $data;

    public function __construct(CurlKinopoiskDefault $data, ParserInterface $parser)
    {
        
        $this->data = $data;
        $this->parser = $parser;
    }
    
    public function setRefferersIntoFile($list)
    {
        $data = $this->data->getData($list);
        $odd = $this->parser->parse($data, './/tr[@class=\'odd\']//a/@href');
        $even = $this->parser->parse($data, './/tr[@class=\'even\']//a/@href');
        $result = array_merge($odd, $even);

        $fp = fopen(BaseCurl::REFERERS_FILE, 'ab');
        foreach ($result as $url) {
            fwrite($fp, $url . PHP_EOL);
        }
        fclose($fp);
    }
}
