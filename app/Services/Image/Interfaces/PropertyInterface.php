<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Services\Image\Interfaces;

/**
 *
 * @author KNovikov
 */
interface PropertyInterface
{

    public function getWidth();

    public function getHeight();

    public function getRatio();

    public function getNewWidth();

    public function getNewHeight();

    public function scale();

    public function scaleByWidth();

    public function scaleByHeight();
}
