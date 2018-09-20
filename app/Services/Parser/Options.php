<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Services\Parser;

use App\Services\Parser\CheckProxy;

/**
 * Description of Options
 *
 * @author KNovikov
 */
class Options extends CheckProxy
{
    public function getPaths()
    {
        $paths = [];
        foreach ($this->inputs as $key => $path){
            dd($key);
            if ($path == 'path') {
                $path[] = $key;
            }
        }
        dd($paths);
    }
}
