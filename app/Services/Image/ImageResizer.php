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
class ImageResizer extends ImageInfo implements ImageInterface
{

    private $result = [];

    /**
     * 
     * @param type $image
     * @param type $width_new
     * @param type $height_new
     * @return boolean
     */
    public function resize($image, $width_new = 100)
    {
        //dd($image);

        $file_info = $this->validate($image);

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

        $save_func($img_dst, '2.jpg', 90); // Сохраняем изображение в тот же файл, что и исходное, возвращая результат этой операции

        /* Вызываем функцию с целью уменьшить изображение до ширины в 100 пикселей, а высоту уменьшив пропорционально, чтобы не искажать изображение */
        //resize("image.jpg", 100); // Вызываем функцию
    }

    public function validate($image)
    {
        
        
        $result['errors'][] = 'Некорректное изображение' . $mime;

        
        return $result;
    }

    public function save($image, $name)
    {
        //$file_info = $this->validate($image);

//        if (array_key_exists('errors', $file_info)) {
//            return $file_info['errors'];
//        }

        //$path_info = pathinfo($image);
        $tmp_name = $_FILES['image']['tmp_name'];
        $ext = $this->getImageMime($image);

        dd($ext);

        if (!move_uploaded_file($tmp_name, 'storage/poster/' . $name . '.' . $ext)) {
            $result['errors'][] = 'При записи изображения на диск произошла ошибка.';
        }
    }

}
