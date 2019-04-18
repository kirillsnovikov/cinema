<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Services\Di;

use App\Services\Di\Interfaces\FirstInterface;
use App\Services\Di\Interfaces\SecondInterface;

/**
 * Description of SecondClass
 *
 * @author KNovikov
 */
class HandlerClass
{

    /**
     * @var App\Services\Di\Interfaces\SecondInterface
     */
    private $second;

    /**
     * @var Interfaces\FirstInterface
     */
    private $firts;

    public function __construct(FirstInterface $firts, SecondInterface $second)
    {
        
        $this->firts = $firts;
        $this->second = $second;
    }
    
    public function result()
    {
        $first = $this->firts->getFirstNumber();
        $second = $this->second->getSecondNumber(124);
        
        dd($first, $second);
    }
}
