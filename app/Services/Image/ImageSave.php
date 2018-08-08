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

    public function imageSave($file, $id, $model, array $sizes)
    {
        $this->folder_number = ceil($id / 1000) . '/';
        $this->folder_size = $this->sizes[4];
        $this->imageModel($id, $model);
        $this->saveDataBase($id);
        $this->makeDir();

        $this->image = new Image($file);

        $this->image->save($this->directory . $this->filename . '.jpg');
        $this->thumbnails($sizes, $file);
    }

    public function imageDelete($id, $model)
    {
        $this->folder_number = ceil($id / 1000) . '/';
        $this->imageModel($id, $model);
        $this->makeFilename($id);

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

    public function imageModel($id, $model)
    {
        if (strcasecmp($model, 'movie') == 0) {
            $this->folder = 'poster/';
            $this->article = Movie::find($id);
        } elseif (strcasecmp($model, 'person') == 0) {
            $this->folder = 'portrait/';
            $this->article = Person::find($id);
        }
    }

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

    public function saveDataBase($id)
    {
        $this->makeFilename($id);
        $this->article->image_name = $this->folder_number . $this->filename . '.jpg';
        $this->article->save();
    }

    public function makeFilename($id)
    {
        $this->filename = $this->article->slug;
    }

}
