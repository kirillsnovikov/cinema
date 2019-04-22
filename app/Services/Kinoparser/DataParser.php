<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Services\Kinoparser;

use App\Contracts\Kinoparser\ParserInterface;

/**
 * Description of CurlParser
 *
 * @author Кирилл
 */
class DataParser implements ParserInterface
{

    public function parse($data, $path): array
    {
        $xpath = $this->createDomXPath($data);
        $elements = $xpath->query($path);

        $result = [];
        foreach ($elements as $element) {
            $value = trim($element->nodeValue);
            $result[] = $value;
        }

        return $result;
    }

    protected function createDomXPath($data)
    {
        $dom = new \DOMDocument;
        $dom->loadHTML($data, LIBXML_NOERROR);
        $xpath = new \DomXPath($dom);
        return $xpath;
    }

}
