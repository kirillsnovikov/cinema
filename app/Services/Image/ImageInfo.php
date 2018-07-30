<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Services\Image;

/**
 * Description of ImageInfo
 *
 * @author KNovikov
 */
class ImageInfo
{

    protected function getOriginalName()
    {
        $original_name = $_FILES['image']['name'];
        return $original_name;
    }

    protected function getTempPath()
    {
        $temp_path = $_FILES['image']['tmp_name'];
        return $temp_path;
    }

    protected function getSize()
    {
        $size = $_FILES['image']['size'];
        return $size;
    }

    protected function getOriginalExtension()
    {
        $original_ext = pathinfo($this->getOriginalName(), PATHINFO_EXTENSION);
        return $original_ext;
    }

    protected function getMimeType($image)
    {
        $type = exif_imagetype($image);
        return $type;
    }

}
