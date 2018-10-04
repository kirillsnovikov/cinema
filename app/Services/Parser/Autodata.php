<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Services\Parser;

/**
 * Description of Autodata
 *
 * @author KNovikov
 */
class Autodata
{

//    public function __construct()
//    {
//        $this->getHiddenKeys();
//    }

    public function getLoginParameters($keys = null)
    {
        $post = [];
        if ($keys != null) {
            $post['form_build_id'] = $keys['form_build_id'];
            $post['form_id'] = $keys['form_id'];
            $post['name'] = 'kirillsnovikov';
            $post['pass'] = 'UmSzenZ91W';
        }
        return $post;
    }
    
    public function getManufactures($json)
    {
        $manufactures = [];
//        $result = [];
        foreach ($json as $item) {
            if (!array_key_exists('ocurrences', $item)) {
                $manufactures[$item['manufacturer']]['link'] = 'https://workshop.autodata-group.com/w1/model-selection/manufacturers/'.$item['uid'];
                $manufactures[$item['manufacturer']]['id'] = $item['id'];
                $manufactures[$item['manufacturer']]['uid'] = $item['uid'];
            }
        }
//        dd($manufactures);
        return $manufactures;
    }
    
    public function getModels($json)
    {
        $models = [];
        
        foreach ($json as $key => $item) {
            if (!array_key_exists('ocurrences', $item)) {
                $models[] = $item;
//                dd($model);
            }
        }
//        dd($models);
        return $manufactures;
    }

}
