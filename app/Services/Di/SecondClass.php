<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Services\Di;

use App\Services\Di\Interfaces\FirstInterface;

/**
 * Description of SecondClass
 *
 * @author KNovikov
 */
class SecondClass
{

    /**
     * @var Interfaces\FirstInterface
     */
    private $firts;

    public function __construct(FirstInterface $firts)
    {
        
        $this->firts = $firts;
    }
    
    public function result()
    {
        return $this->firts->getFirstNumber();
    }
}
