<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Services\Di;

use App\Services\Di\Interfaces\SecondInterface;
use App\Services\Di\Interfaces\UrlGetterInterface;

/**
 * Description of SecondClass
 * @author KNovikov
 */
class HandlerClass
{
    
    /**
     * @var Interfaces\SecondInterface
     */
    private $parser;
    
    /**
     * @var Interfaces\UrlGetterInterface
     */
    private $urlGetter;
    
    public function __construct(UrlGetterInterface $urlGetter, SecondInterface $parser)
    {
        $this->urlGetter = $urlGetter;
        $this->parser    = $parser;
    }
    
    public function result()
    {
        $urls = $this->urlGetter->getUrls();
    
        foreach ($urls as $url) {
        
            $html = $this->loadHtml($url);
        
            $result = $this->parser->parse($html);
        }
        //$second = $this->second->getSecondNumber(124);
    
        dd($urls, $result);
    }
    
    /**
     * @param string $url
     * @return false|string
     */
    private function loadHtml(string $url)
    {
        return file_get_contents($url);
    }
}
