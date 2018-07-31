<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Services\Image;

use App\Services\Image\ImageInfo;

/**
 * Description of ImageValidator
 *
 * @author KNovikov
 */
class ImageValidator extends ImageInfo
{

    protected $result = [];
    protected $width = 0;
    protected $height = 0;
    protected $size = 0;
    protected $original_name = '';
    protected $original_ext = '';
    protected $temp_path = '';
    protected $mime_type = '';

    protected function validate($image)
    {
        list($width, $height) = getimagesize($image);
        if (isset($width) && is_numeric($width) && $width > 100 && isset($height) && is_numeric($height) && $height > 100) {
            $result['width'] = $width;
            $result['height'] = $height;
        } else {
            $result['errors'][] = 'Размер изображения меньше 100 px';
        }

        $size = $this->getSize();
        if (is_numeric($size) && $size < 52428800) {
            $result['size'] = $size;
        } else {
            $result['errors'][] = 'Недопустимый размер файла больше 50Мб';
        }

        $original_name = $this->getOriginalName();
        if ($original_name != '') {
            $result['original_name'] = $original_name;
        } else {
            $result['errors'][] = 'Отсутствует название файла';
        }

        $original_ext = $this->getOriginalExtension();
        if ($original_ext != '') {
            $result['original_ext'] = $original_ext;
        } else {
            $result['errors'][] = 'Отсутствует расширение файла';
        }

        $temp_path = $this->getTempPath();
        if ($temp_path != '') {
            $result['temp_path'] = $temp_path;
        } else {
            $result['errors'][] = 'Временный путь файла отсутствует';
        }

        $type = $this->getMimeType($image);
        if ($type >= 1 && $type <= 3) {
            $mime_type = image_type_to_extension($type, $include_dot = FALSE);
            $result['mime_type'] = $mime_type;
        } else {
            $result['errors'][] = 'Файл не является изображением';
        }

        return $result;
    }

}
