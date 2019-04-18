<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Services\Di;

use App\Services\Di\Interfaces\UrlGetterInterface;

/**
 * Description of MockUrlGetterClass
 * @author KNovikov
 */
class MockUrlGetterClass implements UrlGetterInterface
{
    /**
     * @return array
     */
    public function getUrls(): array
    {
        return [
            'https://static.chipdip.ru/lib/991/DOC003991974.jpg',
            'https://static.chipdip.ru/lib/991/DOC003991978.jpg',
            'https://static.chipdip.ru/lib/991/DOC003991982.jpg',
            'https://static.chipdip.ru/lib/991/DOC003991949.jpg',
            'https://static.chipdip.ru/lib/991/DOC003991960.jpg',
            'https://static.chipdip.ru/lib/991/DOC003991966.jpg',
            'https://static.chipdip.ru/lib/991/DOC003991956.jpg',
            'https://static.chipdip.ru/lib/991/DOC003991940.jpg',
            'https://static.chipdip.ru/lib/991/DOC003991944.jpg',
            'https://static.chipdip.ru/lib/991/DOC003991970.jpg',
        ];
    }
    
}
