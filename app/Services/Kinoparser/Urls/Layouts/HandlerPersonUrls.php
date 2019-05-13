<?php

namespace App\Services\Kinoparser\Urls\Layouts;

use App\Contracts\Kinoparser\ParserInterface;
use App\Contracts\Kinoparser\UrlsGetterInterface;
use App\Services\Kinoparser\Data\KinopoiskDataGetter;
use App\Services\Kinoparser\Data\Layouts\CurlKinopoiskDefault;

/**
 * Description of HandlerPersonUrls
 *
 * @author Кирилл
 */
class HandlerPersonUrls implements UrlsGetterInterface
{

    /**
     * @var ListsOfPersonGetter
     */
    private $list;

    /**
     * @var \App\Contracts\Kinoparser\ParserInterfacer
     */
    private $parser;

    /**
     * @var KinopoiskDataGetter
     */
    private $data;

    public function __construct(CurlKinopoiskDefault $data, ParserInterface $parser, ListsOfPersonGetter $list)
    {

        $this->data = $data;
        $this->parser = $parser;
        $this->list = $list;
    }

    public function getAll(): array
    {
        $this->list->getUrlsLists();
        $data = $this->data->getData('http://news-bitcoin.ru/');
        $links = $this->parser->parse($data, './/h2[@class=\'title\']/a/@href');
        return $links;
    }

}
