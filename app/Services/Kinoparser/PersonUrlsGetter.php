<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Services\Kinoparser;

use App\Contracts\Kinoparser\DataGetterInterface;
use App\Contracts\Kinoparser\ParserInterface;
use App\Contracts\Kinoparser\UrlsGetterInterface;

/**
 * Description of PersonUrlGetter
 *
 * @author KNovikov
 */
class PersonUrlsGetter implements UrlsGetterInterface
{

    /**
     * @var DataGetterInterface
     */
    private $data;

    /**
     * @var ParserInterface
     */
    private $parser;

    public function __construct(DataGetterInterface $data, ParserInterface $parser)
    {
        
        $this->parser = $parser;
        $this->data = $data;
    }

    public function all(): array
    {
        return $this->getLinksFromPage();
    }

    protected function getLinksFromPage()
    {
        $data = $this->data->getData('http://news-bitcoin.ru/');
//        $data = file_get_contents('http://news-bitcoin.ru/', false);
        $links = $this->parser->parse($data, './/h2[@class=\'title\']/a/@href');
        return $links;
    }

}
