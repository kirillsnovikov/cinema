<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Helpers;

use App\Helpers\Contracts\ImageInterface;

/**
 * Description of ImageResizer
 *
 * @author KNovikov
 */
class ImageResizer implements ImageInterface
{
    public function resize(string $param)
    {
        return $param;
    }
}
