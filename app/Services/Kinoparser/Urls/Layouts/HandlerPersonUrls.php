<?php

namespace App\Services\Kinoparser\Urls\Layouts;

use App\Contracts\Kinoparser\UrlsGetterInterface;
use App\Services\Kinoparser\Data\KinopoiskDataGetter;
use App\Services\Kinoparser\Parser\XpathParser;

/**
 * Description of HandlerPersonUrls
 *
 * @author Кирилл
 */
class HandlerPersonUrls implements UrlsGetterInterface
{

    /**
     * @var \App\Contracts\Kinoparser\ParserInterfacer
     */
    private $parser;

    /**
     * @var KinopoiskDataGetter
     */
    private $data;

    public function __construct(KinopoiskDataGetter $data, XpathParser $parser)
    {

        $this->data = $data;
        $this->parser = $parser;
    }

    public function getAll(): array
    {
        $data = $this->data->getData('http://news-bitcoin.ru/');
        $links = $this->parser->parse($data, './/h2[@class=\'title\']/a/@href');
        return $links;
    }

}
