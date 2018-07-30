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
class ImageResizer extends ImageValidator implements ImageInterface
{
    //private $result = [];

    /**
     * 
     * @param type $image
     * @param type $width_new
     * @param type $height_new
     * @return boolean
     */
    public function resize($image, $name, $id, $width_new = 100)
    {
        $result = $this->save($image, $name, $id);
        //dd($result);

        $type = $result['mime_type'];
        $width = $result['width'];
        $height = $result['height'];
        // Получаем названия функций, соответствующие типу изображения
        $create_func = 'imagecreatefrom' . $type;
        $save_func = 'image' . $type;
        $ratio = round($width / $width_new, 3);
        $height_new = $height / ($ratio);

        // Создаём дескриптор для исходного изображения
        $img_src = $create_func($result['path']);
        // Создаём дескриптор для выходного изображения
        $img_dst = imagecreatetruecolor($width_new, $height_new);
        imagecopyresampled($img_dst, $img_src, 0, 0, 0, 0, $width_new, $height_new, $width, $height); // Переносим изображение из исходного в выходное, масштабируя его

        $path = 'storage/poster/small/' . ceil($id / 1000) . '/';
        //dd(file_exists($path));

        if (!file_exists($path)) {
            mkdir($path, 0666, TRUE);
        }
        $save_func($img_dst, $path . $name . '.' . $result['original_ext']); // Сохраняем изображение в тот же файл, что и исходное, возвращая результат этой операции

        return $result;

        /* Вызываем функцию с целью уменьшить изображение до ширины в 100 пикселей, а высоту уменьшив пропорционально, чтобы не искажать изображение */
        //resize("image.jpg", 100); // Вызываем функцию
    }

//    public function validate($image)
//    {
//        
//        
//        $result['errors'][] = 'Некорректное изображение' . $mime;
//
//        
//        return $result;
//    }

    public function save($image, $name, $id)
    {

        $result = $this->validate($image);
        $path = 'storage/poster/original/' . ceil($id / 1000) . '/';

        if (!file_exists($path)) {
            mkdir($path, 0666, TRUE);
        }

        if (!array_key_exists('errors', $result)) {
            $ext = $result['original_ext'];
            $temp_path = $result['temp_path'];

            if (!move_uploaded_file($temp_path, $path . $name . '.' . $ext)) {
                $result['errors'][] = 'При записи изображения на диск произошла ошибка.';
                return $result;
            }
            $result['path'] = $path . $name . '.' . $ext;
            return $result;
        } else {
            return $result;
        }
    }

    public function delete($image, $id)
    {
        $path = 'storage/poster/' . ceil($id / 1000) . '/';
        if (file_exists($path . $image)) {
            unlink($path . $image);
        }
    }

}
