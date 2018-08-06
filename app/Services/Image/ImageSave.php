<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Services\Image;

use App\Services\Image\Image;
use App\Services\Image\Interfaces\ImageSaveInterface;
use App\Movie;
use App\Person;

/**
 * Description of ImageSave
 *
 * @author Кирилл
 */
class ImageSave extends Image implements ImageSaveInterface
{

    public $folder;
    public $folder_number;
    public $folder_size = 'original/';

    public function imageSave($file, $filename, $id, $model, $sizes)
    {
        if (strcasecmp($model, 'movie') == 0) {
            $this->folder = 'poster/';
            $article = Movie::find($id);
        } elseif (strcasecmp($model, 'person') == 0) {
            $this->folder = 'portrait/';
            $article = Person::find($id);
        }

        $this->folder_number = ceil($id / 1000) . '/';

        $directory = 'storage/' . $this->folder . $this->folder_size . $this->folder_number;
        $this->makeDir($directory);

        $image = new Image($file);

        $image->save($directory . $filename . '.jpg');

        dd('sdf');
        foreach ($sizes as $width) {
            if ($width > 0 && $width <= 150) {
                $this->folder_size = mb_strtolower('small');
            } elseif ($width > 150 && $width <= 350) {
                $this->folder_size = mb_strtolower('medium');
            } elseif ($width > 350) {
                $this->folder_size = mb_strtolower('big');
            }
        }
    }

    public function makeDir($directory)
    {
        if (!file_exists($directory)) {
            mkdir($directory, 0666, TRUE);
        }
    }

}
