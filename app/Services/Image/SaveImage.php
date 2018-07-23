<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Services\Image;

use App\Services\Interfaces\ImageInterface;

/**
 * Description of SaveImage
 *
 * @author KNovikov
 */
class SaveImage implements ImageInterface
{
    //put your code here
    

    public function save(string $param)
    {
        echo '{$param}.<br>';
    }

}
