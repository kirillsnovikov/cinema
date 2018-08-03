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
    public function resize($image, $folder, $id, $name, $width_new = [100, 300])
    {
        $result = $this->jpeg($image, $name, $id);
        if (!array_key_exists('errors', $result)) {

            $width = $result['width'];
            $height = $result['height'];
            $ratio = round($width / $width_new, 3);
            $height_new = $height / ($ratio);

            // Создаём дескриптор для исходного изображения
            $img_src = imagecreatefromjpeg($result['full_path']);
            // Создаём дескриптор для выходного изображения
            $img_dst = imagecreatetruecolor($width_new, $height_new);
            imagecopyresampled($img_dst, $img_src, 0, 0, 0, 0, $width_new, $height_new, $width, $height);

            $path = 'storage/poster/small/' . ceil($id / 1000) . '/';

            if (!file_exists($path)) {
                mkdir($path, 0666, TRUE);
            }
            imagejpeg($img_dst, $path . $name . '.jpg');

            return $result;
        }

        return $result;
    }

    public function save($image, $name, $id)
    {

        $result = $this->validate($image);

        if (!array_key_exists('errors', $result)) {
            $folder = ceil($id / 1000);
            $path_folder = 'storage/poster/original/' . $folder . '/';
            if (!file_exists($path_folder)) {
                mkdir($folder, 0666, TRUE);
            }
            $ext = $result['original_ext'];
            $temp_path = $result['temp_path'];
            $path = $folder . $name . '.' . $ext;

            if (!move_uploaded_file($temp_path, $path)) {
                $result['errors'][] = 'При записи изображения на диск произошла ошибка.';
                return $result;
            }
            $result['path'] = $folder;
            $result['name'] = $name;
            $result['full_path'] = $path;
            return $result;
        } else {
            return $result;
        }
    }

    public function jpeg($image, $name, $id)
    {
        $result = $this->save($image, $name, $id);
        if (!array_key_exists('errors', $result)) {
            $type = $result['mime_type'];
            $createfunc = 'imagecreatefrom' . $type;
            $full_path = $result['path'] . $result['name'] . '.jpg';

            if ($type == 'jpeg') {
                return $result;
            } else {
                $im = $createfunc($result['path'] . $result['name'] . '.' . $result['original_ext']);
                $bg = imagecreatetruecolor(imagesx($im), imagesy($im));
                imagefill($bg, 0, 0, imagecolorallocate($bg, 255, 255, 255));
                imagealphablending($bg, TRUE);
                imagecopy($bg, $im, 0, 0, 0, 0, imagesx($im), imagesy($im));
                imagedestroy($im);
                imagejpeg($bg, $full_path, 90);
                imagedestroy($bg);
                $this->delete($result['name'] . '.' . $result['original_ext'], $id);
                $result['full_path'] = $full_path;
                return $result;
            }
        }
        return $result;
    }

    public function delete($image, $id)
    {
        $path_original = 'storage/poster/original/' . ceil($id / 1000) . '/' . $image;
        $path_small = 'storage/poster/small/' . ceil($id / 1000) . '/' . $image;
        if (file_exists($path_original)) {
            unlink($path_original);
        }
        if (file_exists($path_small)) {
            unlink($path_small);
        }
    }

}
