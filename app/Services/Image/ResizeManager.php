<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Services\Image;

/**
 * Description of ResizeManager
 *
 * @author KNovikov
 */
class ResizeManager
{

    /**
     *
     * @var ResizerInterface
     */
    private $resizer;

    /**
     *
     * @var string
     */
    private $path;

    /**
     *
     * @var array
     */
    private $sizes;
    
    /**
     * 
     * @param \App\Services\Image\ResizerInterface $resizer
     * @param string $path
     * @param array $sizes
     */
    function __construct(ResizerInterface $resizer, string $path, array $sizes)
    {
        $this->resizer = $resizer;
        $this->path = $path;
        $this->sizes = $sizes;
    }

    /**
     * 
     * @param string $src
     * @return array
     */
    public function resize(string $src)
    {
        $hash = md5($src);
        
        $chars = str_split($hash);
        
        $path = "/{$chars[0]}/{$chars[1]}/{$chars[2]}/{$hash}";
        
        $dst = "{$this->path}{$path}";
        
        return $this->resizer->resize($src, $dst, $this->sizes);
    }
}
