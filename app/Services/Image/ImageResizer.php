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
    public function resize($image, $width_new = 100)
    {

        $ext = $this->validate($image);

        //dd($ext);

        // Получаем размеры
//        $width = imagesx($image);
//        $height = imagesy($image);
        list($width, $height) = getimagesize($image);

        // Массив с типами изображений
        // Зная "числовой" тип изображения, узнаём название типа
        //$ext = $types[$type];

        if ($ext) {
            $func = 'imagecreatefrom' . $ext; // Получаем название функции, соответствующую типу, для создания изображения
            $img_i = $func($image); // Создаём дескриптор для работы с исходным изображением
        } else {
            echo 'Некорректное изображение'; // Вернем ошибку, если формат изображения недопустимый
            return false;
        }

        $ratio = round($width / $width_new, 3);
        $height_new = $height / ($ratio);

        /* Если указать только 1 параметр, то второй подстроится пропорционально */


        $img_o = imagecreatetruecolor($width_new, $height_new); // Создаём дескриптор для выходного изображения
        imagecopyresampled($img_o, $img_i, 0, 0, 0, 0, $width_new, $height_new, $width, $height); // Переносим изображение из исходного в выходное, масштабируя его

        $func = 'image' . $ext; // Получаем функция для сохранения результата

        return $func($img_o, $image); // Сохраняем изображение в тот же файл, что и исходное, возвращая результат этой операции

        /* Вызываем функцию с целью уменьшить изображение до ширины в 100 пикселей, а высоту уменьшив пропорционально, чтобы не искажать изображение */
        //resize("image.jpg", 100); // Вызываем функцию
    }

    public function validate($image)
    {
        //$ext = $image->getClientOriginalExtension();

        $ext = exif_imagetype($image);
        //$type = $path_info['extension'];

        if ($ext >= 1 && $ext <= 3) {
            $types = [
                '', 'gif', 'jpeg', 'png'
            ];

            $type = $types[$ext];
            return $type;
        } else {
            echo 'Файл не является изображением';
            return FALSE;
        }
         
    }

//    public function save($image, $name)
//    {
//        
//    }
}
