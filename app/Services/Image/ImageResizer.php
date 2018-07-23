<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Services\Image;

use App\Services\Interfaces\ImageInterface;

/**
 * Description of ImageResizer
 *
 * @author Кирилл
 */
class ImageResizer implements ImageInterface
{

    /**
     * 
     * @param string $param
     */
    public function resize(string $param)
    {
        return $param;
    }

    public function rename(string $param)
    {
        return $param;
    }

    public function save(string $param)
    {
        return $param;
    }

}
