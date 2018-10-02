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

}
