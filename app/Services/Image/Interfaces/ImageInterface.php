<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Services\Image\Interfaces;

/**
 *
 * @author Кирилл
 */
interface ImageInterface
{

    public function load($filename);

    public function save($filename, $image_type = IMAGETYPE_JPEG, $compression = 75, $permissions = null);

    public function getWidth();

    public function getHeight();

    public function resizeToHeight($height);

    public function resizeToWidth($width);

    public function scale($scale);

    public function resize($width, $height);
}
