<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Services\Kinoparser\Person;

use App\Services\Kinoparser\Data\Layouts\CurlKinopoiskDefault;
use Illuminate\Support\Facades\Storage;

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

        if (!preg_match('#\d+#', $url, $options)) {
            $fp = fopen(__DIR__ . '/../config/errors.txt', 'ab');
            fwrite($fp, $url . ' || Url have not number of person' . PHP_EOL);
            fclose($fp);
            return;
        }

        $data = $this->data->getData($url);
        $folder_number = ceil(last($options) / 10000);
        $filename = last($options) . '.html';
        $path = $folder_number . '/' . $filename;
        Storage::disk('person')->put($path, $data);
    }

}
