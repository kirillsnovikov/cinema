<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Services\Image;

use App\Services\Interfaces\ResizerInterface;

/**
 * Description of ImagicResizer
 *
 * @author KNovikov
 */
class ImagicResizer implements ResizerInterface
{
    public function resize(string $size)
    {
        echo 'тестовая строка';
    }
}
