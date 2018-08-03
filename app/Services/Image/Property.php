<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Services\Image;

use App\Services\Image\Interfaces\PropertyInterface;
use App\Image\Exception\PropertyException;

/**
 * Description of Property
 *
 * @author KNovikov
 */
class Property implements PropertyInterface
{

    private $heigt;

    /**
     *
     * @var type integer
     */
    private $width;

    /**
     *
     * @var type integer
     */
    private $height;

    public function __construct($width, $heigt)
    {
        if ($width < 10 || $heigt < 10) {
            throw new PropertyException('Ширина или высота меньше 10px');
        }

        $this->width = $width;
        $this->heigt = $heigt;
    }

    public function getWidth()
    {
        return $this->width;
    }

    public function getHeight()
    {
        return $this->height;
    }

    public function getNewHeight()
    {
        
    }

    public function getNewWidth()
    {
        
    }

    public function getRatio()
    {
        
    }

    public function scale()
    {
        
    }

    public function scaleByHeight()
    {
        
    }

    public function scaleByWidth()
    {
        
    }

}
