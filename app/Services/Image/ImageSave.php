<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Services\Image;

use App\Services\Image\Image;
use App\Services\Image\Interfaces\ImageSaveInterface;
use Illuminate\Support\Str;
use App\Movie;
use App\Person;

/**
 * Description of ImageSave
 *
 * @author Кирилл
 */
class ImageSave extends Image implements ImageSaveInterface
{

    public $image;
//    public $id;
//    public $model;
    public $folder;
    public $folder_number;
    public $folder_size;
    public $directory;
    public $article;
    public $filename;
    public $sizes = [
        'small/',
        'medium/',
        'normal/',
        'big/',
        'original/',
    ];

    public function imageSave($file, $model, array $sizes)
    {
//        dd(basename(get_class($model)));
//        $this->id = $model->id;
//        $this->model = get_class($model);
        $this->article = $model;
        $this->getFolderNames();
        $this->getFilename();
//        dd($this->folder);
//        $this->imageModel($id, $model);
        $this->saveDataBase();
        $this->makeDir();

        $this->image = new Image($file);

        $this->image->save($this->directory . $this->filename . '.jpg');
        $this->thumbnails($sizes, $file);
    }

    public function imageDelete($model)
    {
        $this->article = $model;
        $this->getFolderNames();
        $this->getFilename();

//        $this->folder_number = ceil($model->id / 1000) . '/';
//        $this->imageModel($id, $model);

        foreach ($this->sizes as $size) {
            $path = 'storage/' . $this->folder . $size . $this->folder_number . $this->filename . '.jpg';
            $this->delDir($path);
        }
    }

    public function thumbnails($sizes, $file)
    {
        foreach ($sizes as $width) {
            if ($width > 0 && $width <= 150) {
                $this->folder_size = mb_strtolower($this->sizes[0]);
                $this->makeDir();
                $this->makeThumbnail($width, $file);
            } elseif ($width > 150 && $width <= 350) {
                $this->folder_size = mb_strtolower($this->sizes[1]);
                $this->makeDir();
                $this->makeThumbnail($width, $file);
            } elseif ($width > 350 && $width <= 1024) {
                $this->folder_size = mb_strtolower($this->sizes[2]);
                $this->makeDir();
                $this->makeThumbnail($width, $file);
            } elseif ($width > 1024) {
                $this->folder_size = mb_strtolower($this->sizes[3]);
                $this->makeDir();
                $this->makeThumbnail($width, $file);
            }
        }
    }

//    public function imageModel($id, $model)
//    {
//        $fullm = '\\App\\' . $model;
////        dd($fullm);
//        $this->folder = trim(mb_strtolower($model)) . '/';
//        $this->article = $fullm::find($this->id);
//    }

    public function makeDir()
    {
        $this->directory = 'storage/' . $this->folder . $this->folder_size . $this->folder_number;
        if (!file_exists($this->directory)) {
            mkdir($this->directory, 0666, TRUE);
        }
    }

    public function delDir($path)
    {
        if (file_exists($path)) {
            unlink($path);
        }
    }

    public function makeThumbnail($width, $file)
    {
        $this->image = new Image($file);
        $this->image->resizeToWidth($width);
        $this->image->save($this->directory . $this->filename . '.jpg');
    }

    public function saveDataBase()
    {
        $this->article->image = $this->folder_number . $this->filename . '.jpg';
        $this->article->save();
    }

    public function getFilename()
    {
        $this->filename = $this->article->slug;
    }

    public function getFolderNames()
    {
        $this->folder_number = ceil($this->article->id / 1000) . '/';
        $this->folder_size = $this->sizes[4];

        $class_name = explode('\\', get_class($this->article));
        $this->folder = trim(mb_strtolower(array_pop($class_name))) . '/';
    }

}
