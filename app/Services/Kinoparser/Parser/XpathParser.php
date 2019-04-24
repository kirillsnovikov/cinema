<?php

namespace App\Services\Kinoparser\Parser;

use App\Contracts\Kinoparser\ParserInterface;

/**
 * Description of XpathParser
 *
 * @author Кирилл
 */
class XpathParser implements ParserInterface
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
