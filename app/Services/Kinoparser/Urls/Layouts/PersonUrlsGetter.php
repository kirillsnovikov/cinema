<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Services\Kinoparser\Urls\Layouts;

use App\Contracts\Kinoparser\ParserInterface;
use App\Services\Kinoparser\Data\Layouts\CurlKinopoiskDefault;

/**
 * Description of PersonUrlsGetter
 *
 * @author KNovikov
 */
class PersonUrlsGetter
{

    const PESON_URLS = __DIR__ . '/../../config/person_urls.txt';

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

    public function getPersonUrlsByList($list): array
    {
        $data = $this->data->getData($list);
        $result = $this->parser->parse($data, './/p[@class=\'name\']/a/@data-url');

        $fp = fopen(self::PESON_URLS, 'ab');
        foreach ($result as $url_name) {
            $url = 'https://www.kinopoisk.ru' . $url_name;
            $urls[] = $url;
            fwrite($fp, $url . PHP_EOL);
        }
        fclose($fp);
        return $urls;
    }

}
