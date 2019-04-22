<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Services\Kinoparser;

use Illuminate\Http\Request;

/**
 * Description of CurlDataGetter
 *
 * @author Кирилл
 */
abstract class CurlDataGetter
{

    /**
     * @var Request
     */
    private $request;

    public function __construct(Request $request)
    {

        $this->request = $request;
    }
    
    protected function getParameters()
    {
        $parameters = $this->request->all();
        dd($parameters);
    }

}
