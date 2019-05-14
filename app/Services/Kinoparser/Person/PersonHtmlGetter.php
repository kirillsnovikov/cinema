<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Services\Kinoparser\Person;

use App\Services\Kinoparser\Data\Layouts\CurlKinopoiskDefault;

/**
 * Description of PersonHtmlGetter
 *
 * @author KNovikov
 */
class PersonHtmlGetter
{

    /**
     * @var CurlKinopoiskDefault
     */
    private $data;

    public function __construct(CurlKinopoiskDefault $data)
    {

        $this->data = $data;
    }

    public function putHtmlInFile($url)
    {
        $data = $this->data->getData($url);

        $path = \Storage::disk('local')->put('file.txt', 'Contents');
        $path2 = \Storage::disk('images')->put('file2.txt', 'Contents');
//        $url = $path2->temporaryUrl('file.jpg', now()->addMinutes(5));
        $path3 = \Storage::disk('public')->put('file3.txt', 'Contentsss');
//        \Storage::setVisibility('file.jpg', 'public');
//        dd($url);
        dd(\Storage::disk('public')->url('file3.txt'));
        dd($path, $path2);
    }

}
