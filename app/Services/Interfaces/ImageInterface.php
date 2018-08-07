<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Services\Interfaces;

/**
 *
 * @author Кирилл
 */
interface ImageInterface
{

    public function resize($image, $folder, $id, $name, array $width_new);
    
}
