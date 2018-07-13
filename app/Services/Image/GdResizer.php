<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Services\Image;

/**
 * Description of GdResizer
 *
 * @author KNovikov
 */
class GdResizer implements ResizerInterface
{

    public function resize(string $src, string $dst, array $sizes = null): array
    {
        return ['path-1','path-2'];
    }

}
