<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Services\Image;

/**
 * Description of ImagicResizer
 *
 * @author KNovikov
 */
class ImagicResizer implements ResizerInterface
{
    //put your code here
    public function resize(string $src, string $dst, array $sizes = null): array
    {
        $out = [];
        foreach ($sizes as $size) {
            $res = "{$dst}/image{$size}.jpg";
            echo "resizing {$src} to {$res}<br/>";
            $out[$size] = $res;
        }
        return $out;
    }

}
