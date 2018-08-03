<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Services\Image\Interfaces;

/**
 *
 * @author KNovikov
 */
interface FileDataInterface extends ReadFileInterface
{
    public function readFile($file);
    
}
