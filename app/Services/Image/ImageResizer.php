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
     * @param type $image
     * @param type $width_new
     * @param type $height_new
     * @return boolean
     */
    public function resize($image, $width_new = 200)
    {
        //dd($image);

        $ext = $this->validate($image);

        if (is_array($ext)) {
            return $ext;
        }

        // Получаем размеры
        list($width, $height) = getimagesize($image);

        // Получаем названия функций, соответствующие типу изображения
        $create_func = 'imagecreatefrom' . $ext;
        $save_func = 'image' . $ext;

        $ratio = round($width / $width_new, 3);
        $height_new = $height / ($ratio);

        // Создаём дескриптор для исходного изображения
        $img_src = $create_func($image);
        // Создаём дескриптор для выходного изображения
        $img_dst = imagecreatetruecolor($width_new, $height_new);
        imagecopyresampled($img_dst, $img_src, 0, 0, 0, 0, $width_new, $height_new, $width, $height); // Переносим изображение из исходного в выходное, масштабируя его

        return $save_func($img_dst, '1.jpg', 1); // Сохраняем изображение в тот же файл, что и исходное, возвращая результат этой операции

        /* Вызываем функцию с целью уменьшить изображение до ширины в 100 пикселей, а высоту уменьшив пропорционально, чтобы не искажать изображение */
        //resize("image.jpg", 100); // Вызываем функцию
    }

    public function validate($image)
    {
        $type = exif_imagetype($image);
        $errors = [];
        $ext = image_type_to_extension($type, $include_dot = FALSE);

        if ($type >= 1 && $type <= 3) {

            return $ext;
        } else {
            $errors[] = 'Некорректное изображение' . $ext;

            return $errors;
        }
    }

//    public function save($image, $name)
//    {
//        
//    }
}
