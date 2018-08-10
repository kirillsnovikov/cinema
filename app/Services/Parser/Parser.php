<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Services\Parser;

use App\Services\Parser\Interfaces\ParserInterface;

/**
 * Description of Parser
 *
 * @author KNovikov
 */
class Parser implements ParserInterface
{

    public $inputs;

    //put your code here

    public function __construct($inputs = null)
    {
        if ($inputs != null) {
            $this->start($inputs);
        }
    }

    public function start($inputs)
    {
        $this->getInputs($inputs);
        $this->getParseParameters();
    }

    public function getUrls()
    {
        
    }

    public function getParseParameters()
    {
        echo 'Parser START!';
        foreach ($this->inputs as $key => $input) {
            echo ('<br>' . $key . ': ' . $input);
        }
    }

    public function getInputs($inputs)
    {
        $this->inputs = $inputs;
    }

}
