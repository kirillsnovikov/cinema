<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Contracts\Kinoparser;

/**
 *
 * @author Кирилл
 */
interface DataGetterInterface
{

    public function getData(string $url): string;
}
