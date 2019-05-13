<?php

namespace App\Services\Kinoparser\Data\Layouts;

use App\Contracts\Kinoparser\DataGetterInterface;

/**
 * Description of ElementaryGetContent
 *
 * @author Кирилл
 */
class ElementaryGetContent implements DataGetterInterface
{

    /**
     * 
     * @param string $url
     * @return string
     */
    public function getData(string $url): string
    {
        return file_get_contents($url, false);
        usleep(1000000);
    }

}
