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

    protected $errors = [];

    protected function getOriginalName()
    {
        $original_name = $_FILES['image']['name'];
        return $original_name;
    }

    protected function getOriginalExtension()
    {
        $ext = pathinfo($this->getOriginalName(), PATHINFO_EXTENSION);
        return $ext;
    }

    protected function getImageType($image)
    {
        $type = exif_imagetype($image);
        return $type;
    }

    protected function getImageMime($image)
    {
        $mime = image_type_to_extension($this->getImageType($image), $include_dot = FALSE);
        return $mime;
    }

    protected function getMimeType($image)
    {



        if ($type >= 1 && $type <= 3) {
            return $mime;
        } else {
            return FALSE;
        }
    }

}
