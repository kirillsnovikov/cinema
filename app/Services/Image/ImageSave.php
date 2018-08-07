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
    public $folder_size = 'original/';
    public $directory;
    public $article;
    public $filename;

    public function imageSave($file, $id, $model, array $sizes)
    {
        $this->folder_number = ceil($id / 1000) . '/';
        $this->imageModel($id, $model);
        $this->makeDir();

        $this->image = new Image($file);
        
        //$this->image->resizeToWidth(300);
        
        //$this->image->jpeg($this->directory . $this->filename . '.jpg');
        //$this->thumbnails($sizes);
        $this->image->save($this->directory . $this->filename . '.jpg');

        dd('sdf');
        
    }

    public function thumbnails($sizes)
    {
        foreach ($sizes as $width) {
            if ($width > 0 && $width <= 150) {
                $this->folder_size = mb_strtolower('small/');
                $directory = 'storage/' . $this->folder . $this->folder_size . $this->folder_number;
                $this->makeDir();
                $this->makeThumbnail($width);
            } elseif ($width > 150 && $width <= 350) {
                $this->folder_size = mb_strtolower('medium/');
                $directory = 'storage/' . $this->folder . $this->folder_size . $this->folder_number;
                $this->makeDir();
                $this->makeThumbnail($width);
            } elseif ($width > 350) {
                $this->folder_size = mb_strtolower('big/');
                $directory = 'storage/' . $this->folder . $this->folder_size . $this->folder_number;
                $this->makeDir();
                $this->makeThumbnail($width);
            }
        }
    }

    public function imageModel($id, $model)
    {
        if (strcasecmp($model, 'movie') == 0) {
            $this->folder = 'poster/';
            $this->article = Movie::find($id);
            $this->saveDataBase();
        } elseif (strcasecmp($model, 'person') == 0) {
            $this->folder = 'portrait/';
            $this->article = Person::find($id);
            $this->saveDataBase();
        }
    }

    public function makeDir()
    {
        $this->directory = 'storage/' . $this->folder . $this->folder_size . $this->folder_number;
        if (!file_exists($this->directory)) {
            mkdir($this->directory, 0666, TRUE);
        }
    }

    public function makeThumbnail($width)
    {
        $this->image->resizeToWidth($width);
        //$this->image->jpeg();
        //$this->image->save($this->directory . $this->filename . '.jpg');
    }

    public function saveDataBase()
    {
        $this->filename = Str::slug($this->article->title, '_');
        $this->article->image_name = $this->folder_number . $this->filename . '.jpg';
        $this->article->save();
    }

}
