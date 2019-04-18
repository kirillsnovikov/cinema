<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Services\Di;

use App\Services\Di\Interfaces\FirstInterface;

/**
 * Description of MockFirstClass
 *
 * @author KNovikov
 */
class MockFirstClass implements FirstInterface
{
    //put your code here
    public function getFirstNumber(): int
    {
        return 42;
    }

}
