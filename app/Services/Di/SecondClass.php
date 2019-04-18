<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Services\Di;

use App\Services\Di\Interfaces\SecondInterface;

/**
 * Description of MockSecondClass
 *
 * @author KNovikov
 */
class SecondClass implements SecondInterface
{
    //put your code here
    public function getSecondNumber($param): int
    {
        return $param * 5;
    }
    
    /**
     * @param string $html
     * @return string
     */
    public function parse(string $html)
    {
        return $html;
    }
}
