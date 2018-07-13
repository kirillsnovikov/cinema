<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Services\Image;

/**
 *
 * @author KNovikov
 */
interface ResizerInterface
{

    /**
     * 
     * @param string $src
     * @param string $dst
     * @param array $sizes
     * @return array saved paths
     */
    public function resize(string $src, string $dst, array $sizes = null): array;
}
