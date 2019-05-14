<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Kinoparser\Urls\PersonUrlsGetter;
use Illuminate\Support\Facades\Storage;

class CityadsController extends Controller
{

    public $parser;
    public $request_url;
    public $api_url = 'http://cityads.com/api/rest/webmaster/';
    public $remote_auth = '27263c53756d7fba6740b61033c0c715';
    public $limit = 1000;
    public $last_data_file = 'storage/temp/cityads_last_update.txt';
    public $new_data_file = 'storage/temp/cityads_new_update.txt';
    public $format = 'json'; //xml, csv
    public $type = 'statistics-sources';
    public $group_field = 'subaccount'; //subaccount2, subaccount3, subaccount4, subaccount5
    public $date_from = '2019-01-25';
    public $date_to;
    public $last_data;
    public $new_data = [];
    public $diff = [];

    public function zhorzh()
    {


        $urls = ['https://static.chipdip.ru/lib/991/DOC003991974.jpg',
            'https://static.chipdip.ru/lib/991/DOC003991978.jpg',
            'https://static.chipdip.ru/lib/991/DOC003991982.jpg',
            'https://static.chipdip.ru/lib/991/DOC003991949.jpg',
            'https://static.chipdip.ru/lib/991/DOC003991960.jpg',
            'https://static.chipdip.ru/lib/991/DOC003991966.jpg',
            'https://static.chipdip.ru/lib/991/DOC003991956.jpg',
            'https://static.chipdip.ru/lib/991/DOC003991940.jpg',
            'https://static.chipdip.ru/lib/991/DOC003991944.jpg',
            'https://static.chipdip.ru/lib/991/DOC003991970.jpg',
        ];

        if (!file_exists('storage/zhorzh/')) {
            mkdir('storage/zhorzh/', 0666, TRUE);
        }

        foreach ($urls as $key => $url) {

            $filename = 'storage/zhorzh/AAAAA' . basename($url);
            $image = file_get_contents($url);
            file_put_contents($filename, $image);
        }

        dd('success');
    }

    public function index(PersonUrlsGetter $urls)
    {
        $local = Storage::disk('local');
        $public = Storage::disk('public');
//        dd(storage_path());
        dd($local->files(), $public->files());
        dd(asset('storage/file.txt'));
//        $first->getUrls();
//        dd(resolve(\App\Services\Di\HandlerClass::class));
//        resolve(\App\Services\Di\HandlerClass::class)->result();
//        (new \App\Services\Di\SecondClass(\App\Services\Di\Interfaces\UrlGetterInterface::class))->result();
    }

    public function getDifferent()
    {
        $this->getApiData();
//        dd($this->new_data);



        foreach ($this->new_data as $sub2 => $lead2) {
            if (array_key_exists($sub2, $this->last_data)) {
                $diff_lead = (int) $lead2 - (int) $this->last_data[$sub2];
                /* @var $diff_lead type int */
                if ($diff_lead > 0) {
                    $this->diff[$sub2] = $diff_lead;
                }
            } elseif (!array_key_exists($sub2, $this->last_data) && (int) $lead2 > 0) {
                $this->diff[$sub2] = (int) $lead2;
            }
        }

        $this->parser->objectToFile($this->new_data, $this->last_data_file);
//        dd($diff);
    }

    public function getApiData()
    {
        $curl = curl_init();

        $try = TRUE;
        $start_parse_page = 0;

        while ($try) {
            $this->getRequestUrl($start_parse_page);
            curl_setopt_array($curl, array(
                CURLOPT_URL => $this->request_url,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "GET",
                CURLOPT_POSTFIELDS => "",
                CURLOPT_HTTPHEADER => array(
                    'cache-control: no-cache',
                    'Connection: keep-alive',
                    'Host: cityads.com'
                ),
            ));

            $response = json_decode(curl_exec($curl), TRUE);
            $items = $response['data']['items'];

            $err = curl_error($curl);

            if ($items) {
                foreach ($items as $item) {
                    $subaccount = $item['subaccount'];
                    if ($subaccount != '') {
                        $this->new_data[$subaccount] = $item['leadsApproved'];
                    }
                }
                $start_parse_page++;
            } else {
                $try = FALSE;
            }
            usleep(1500000);
        }

        curl_close($curl);
        $this->parser->objectToFile($this->new_data, $this->new_data_file);
//        $this->parser->objectToFile($this->new_data, $this->last_data_file);
    }

    public function getRequestUrl($start_parse_page = 0)
    {
        $this->date_to = date('Y-m-d', time());
//        $this->date_to = '2019-02-07';

        $parameters = [
            'remote_auth' => $this->remote_auth,
            'limit' => $this->limit,
            'start' => $start_parse_page,
        ];

        $this->request_url = $this->api_url . $this->format . '/' . $this->type . '/' . $this->group_field . '/' . $this->date_from . '/' . $this->date_to . '/?' . http_build_query($parameters);
//        dd($this->request_url);
    }

}
