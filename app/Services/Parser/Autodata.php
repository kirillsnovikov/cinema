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
                $manufactures[$item['manufacturer']]['link'] = 'https://workshop.autodata-group.com/w1/model-selection/manufacturers/' . $item['uid'];
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

    public function getEngines($array)
    {
        
    }

    public function autodata($inputs)
    {
        ob_start();
//        dd($inputs);
        $this->getOptions($inputs);

//        инициализируем новую сессию курла
        $this->curlInit();
        $autodata = new Autodata();
        $vars = get_object_vars($this);
//        dd(stripos($this->type, 'autodatalogin'));
//        dd($vars);
//        проверка на тип парсера для ссылок (Link)
        if (stripos($this->type, 'login') > 0) {
            $url = 'https://workshop.autodata-group.com/login?destination=node';
//            file_put_contents($this->cookie, ''); //создаем новые куки
//            dd('logloglog');
            $this->getData($url, 'https://workshop.autodata-group.com/'); //получаем данные страницы
//            dd($this->data);
            $this->getParseResult($this->paths); //выдергиваем данные скрытых полей через xpath и записываем в result
//            dd($this->result);
            $this->post = $autodata->getLoginParameters($this->result); //формируем post данные из полученного result
//            dd($this->post);
            $this->getData($url, $url, $this->post); //логинимся пост запросом
//            dd($this->data);
            if (preg_match("/главную/i", $this->data)) {
                return 'Успешно зашли в систему!';
            } else {
                return 'Возможно, возникли ошибки при входе в систему!';
            }
        } elseif (stripos($this->type, 'link') > 0) {

//            $this->getData('https://workshop.autodata-group.com/w1/model-selection/manufacturers/', $this->last_url);
//            $json_manufactures = json_decode($this->data, true);
//            $manufactures = $autodata->getManufactures($json_manufactures);
////            $models = [];
//            foreach ($manufactures as $key => $value) {
//                $this->getData($value['link'], $this->last_url);
//                $json_models = json_decode($this->data, true);
//                foreach ($json_models as $model) {
//                    if (!array_key_exists('ocurrences', $model)) {
//                        $model['link_engine'] = 'https://workshop.autodata-group.com/w1/manufacturers/' . $value['uid'] . '/' . $model['uid'] . '/engines?route_name=engine-oil&module=TD';
//                        $manufactures[$key][] = $model;
////                        https://workshop.autodata-group.com/selection/save-in-jobfolder/0/undefined
//                    }
//                }
////                dd($manufactures);
//            }
////            $file = file_get_contents('storage/temp/manufactures.json');
////            $array = $this->objectFromFile();
//            $this->objectToFile($manufactures);
//            $array = $this->objectFromFile('storage/temp/engines.txt');
//            dd($array['Alfa Romeo']);
//            dd($this->paths);
//            $post = [];
//            $result = [];
//            foreach ($array as $k => $model) {
//                $i = 0;
//                $count = array_keys($model)[count($model) - 1];
//
//                for ($i; $i <= $count; $i++) {
////                    dd($model[$i]['link_engine']);
//                    $this->getData($model[$i]['link_engine'], $this->last_url);
////                    dd($this->data);
//            $array = $this->objectFromFile('storage/temp/engines.txt');
//            $files = scandir('storage/temp/engines/');
//            $result = [];
////            dd($files);
//            foreach ($files as $filename) {
//                $ext = '.txt';
//                if (stripos($filename, $ext) > 0) {
//                    $file = 'storage/temp/engines/'.$filename;
//                    $model_name = str_ireplace('#', '/', substr($filename, 0, -4));
//                    
////                    dd($model_name);
//                    $array = $this->objectFromFile($file);
//                    $result[$model_name] = $array;
////                    dd($result);
//                }
//            }
//            $this->objectToFile($result, 'storage/temp/engines_models.txt');
//            dd($array);
//            $array = $this->objectFromFile('storage/temp/engines_models_3.txt');

            $array = json_decode(file_get_contents('storage/temp/engines.json'), TRUE);
//            dd($array['Alfa Romeo']);    
//            file_put_contents('storage/temp/engines.json', json_encode($array));
//            dd($array['Proton'][0]);
//            ob_start();

            $script = __DIR__ . '\test.js';
            $script2 = __DIR__ . '\test2.js';
            $script3 = __DIR__ . '\test3.js';
            $autodata_test = __DIR__ . '\autodata_test.js';
            putenv("SLIMERJSLAUNCHER=C:\\Program Files\\Mozilla Firefox\\firefox.exe");
//            dd(shell_exec("C:\slimerjs-1.0.0\slimerjs -createProfile AutodataParser"));
//            dump(shell_exec("C:\slimerjs-1.0.0\slimerjs -P AutodataParser $script"));
//            dd(shell_exec("C:\slimerjs-1.0.0\slimerjs -P AutodataParser $script3"));
//            dd();
//            $post = [];
//            $parameters = [];
            $result = [];
//            $post_keys = [
//                'engine-code-nid',
//                'mecnid',
//                'data-vechicle-nid'
//            ];
//            echo('Start!!!');
            $m = 0;
            $encoding_list = [
                'UTF-8', 'ASCII',
                'ISO-8859-1', 'ISO-8859-2', 'ISO-8859-3', 'ISO-8859-4', 'ISO-8859-5',
                'ISO-8859-6', 'ISO-8859-7', 'ISO-8859-8', 'ISO-8859-9', 'ISO-8859-10',
                'ISO-8859-13', 'ISO-8859-14', 'ISO-8859-15', 'ISO-8859-16',
                'Windows-1251', 'Windows-1252', 'Windows-1254',
            ];
            ob_start();
            foreach ($array as $k => $model) {
//                $k = 'Proton';
//                $model = $array[$k];
                $manufacture = str_replace(' ', '_', $k);
                $manufacture_uid = $model['uid'];
//                $post[] = $manufacture;
                $i = 0;
                $count = array_keys($model)[count($model) - 1];

                for ($i; $i <= $count; $i++) {
                    $bodyname = str_replace(' ', '_', $model[$i]['bodyname']);
                    $model_uid = $model[$i]['uid'];
                    $link_engine = str_replace('https://workshop.autodata-group.com/', '/', $model[$i]['link_engine']);
//                    $post[] = $link_engine;
                    $engine_number = 0;
                    foreach ($model[$i]['engines'] as $model_engine => $engine) {
//                        dd($engine);

                        $count_code = array_keys($engine)[count($engine) - 1];
//                        $post[] = $engine_number;
//                        dd($count_code);
                        $j = 0;
                        for ($j; $j <= $count_code; $j++) {



//                            dd($this->data);
//                            $engine_code_number = $j;
                            $vehicle_id = $engine[$j]['post_data']['data-vechicle-nid'];
//                            $vehicle_id = 'CHE17865';
                            $url = 'https://workshop.autodata-group.com/w1/engine-oil/' . $vehicle_id;
                            $this->getData($url);
                            $path = ".//div[@class='vehicle-info']//li";
                            $this->getXPath();
                            $elements = $this->xpath->query($path);
//                            dd($elements[1]);
//                            $this->getParseResult($path);
                            $code_engine = [];

                            foreach ($elements as $node) {
//                                $name = trim($node->nodeName);
                                $value = trim($node->nodeValue);
//                                $code_engine[] = iconv('UTF-8', 'WINDOWS-1252//IGNORE', $value);
                                $code_engine[] = mb_convert_encoding($value, "WINDOWS-1252", $encoding_list);
//                                $code_engine[] = $value;
//                                $code_engine[] = preg_replace_callback('/\\\\u([0-9a-fA-F]{4})/', function ($match) {
//                                    return mb_convert_encoding(pack('H*', $match[1]), 'UTF-8', 'Windows-1252');
//                                }, $value);
                            }
                            $code = '';
                            foreach ($code_engine as $value) {
                                $code .= $value;
                            }
                            echo $code;
                            ob_flush();
                            flush();

//                            dd($code_engine);
//                            dump(shell_exec("C:\slimerjs-1.0.0\slimerjs -P AutodataParser $autodata_test $manufacture $manufacture_uid $bodyname $model_uid $engine_number $engine_code_number $vehicle_id"));
//                            $content = shell_exec("C:\slimerjs-1.0.0\slimerjs -P AutodataParser $script3 $manufacture $manufacture_uid $bodyname $model_uid $engine_number $engine_code_number $vehicle_id");
//                            $post[] = $engine_code_number;
//                            $try = TRUE;
//                            dd('manufacture ' . $manufacture . PHP_EOL . 'bodyname ' . $bodyname . PHP_EOL . 'engine_number ' . $engine_number . PHP_EOL . 'engine_code_number ' . $engine_code_number . PHP_EOL . 'vehicle_id ' . $vehicle_id . PHP_EOL);
//                            while ($try) {
//
//                                $content = shell_exec("C:\slimerjs-1.0.0\slimerjs -P AutodataParser $script2 $manufacture $manufacture_uid $bodyname $model_uid $engine_number $engine_code_number $vehicle_id");
//                                if ($content == null) {
//                                    $try = TRUE;
////                                    echo ' --- ' . $m . ' --- ' . strlen($content) . ' --- BAD RESULT!! <br>';
//                                } else {
//                                    $try = FALSE;
////                                    echo ' --- ' . $m . ' --- ' . strlen($content) . ' --- OK!! <br>';
//                                }
////                                ob_flush();
////                                flush();
//                            }
//                            dd($content);

                            $m++;
                            $engine[$j]['card_content'] = $this->data;
                            $model[$i]['engines'][$model_engine] = $engine;
                            $result[$k] = $model;
//                            dd($result);

                            $this->objectToFile($result, 'storage/temp/card_content.txt');
//                            dd($content);
//                            dd($engine);
//                            $link_engine = $model[$i]['link_engine'];
//                            $vehicle_id = $engine[$j]['post_data']['data-vechicle-nid'];
//                            $engine_id = $engine[$j]['post_data']['engine-code-nid'];
//                            $module_id = $engine['post_data']['module'];
//                            $post['back'] = '';
//                            $post['engine_id'] = $engine_id;
//                            $post['engine_name'] = $engine_id;
//                            $post['module_id'] = $module_id;
//                            $post['route_name'] = 'engine-oil';
//                            $post['vehicle_id'] = $vehicle_id;
//
//                            $url = "https://workshop.autodata-group.com/w1/vehicle-selection/mid/$vehicle_id";
                        }
                        dd($result);
//                        dd($post);
                        $engine_number++;
                    }
                    dd($result);
                }
            }
//            dd($post);
//            dump($result['Volvo'][0]);
            return 'Сбор ссылок закончен!';
//                            dd($url);
//                            $test = count($engine[$j]['post_data']);
//                            $post[] = $test;
//                            $post_result = [];
//                            foreach ($post_keys as $post_key) {
//                                if (isset($engine[$j]['post_data'][$post_key]))
////                                    $post_result[$post_key] = $engine[$j]['post_data'][$post_key];
//                                    $post_result[$post_key] = $engine[$j]['post_data'][$post_key];
//                            }
//                            $engine[$j]['post_data'] = $post_result;
//                            dd($engine);
//                            foreach ($engine[$j]['post_data'] as $key => $value) {
//                                $chars = ['\"', '\n']; // символы для удаления
//                                $new_value = stripslashes(str_replace($chars, '', $value));
//                                $engine[$j]['post_data'][$key] = $new_value;
//                                $post[] = $new_value;
//                            }
//                            foreach ($engine[$j]['parameters'] as $p => $val) {
//                                $chars = ['\"', '\n']; // символы для удаления
//                                $new_val = stripslashes(str_replace($chars, '', $val));
//                                $engine[$j]['parameters'][$p] = trim($new_val);
//                            }
//                        $model[$i]['engines'][$model_engine] = $engine;
//                        $result[$k] = $model;
//
//                        $post_data = $engine['post_data'];
//                        $manufacturer = urlencode($post_data['manufacturer']);
//                        $body = urlencode($post_data['body']);
//                        $litres = urlencode($post_data['litres']);
//                        $fuel = urlencode($post_data['fuel']);
//                        $freetext = urlencode($post_data['freetext']);
//                        $module = urlencode($post_data['module']);
//                        $vehicletype = urlencode($post_data['vehicletype']);
//                        dd($post_data);
//                        $query_url = "https://workshop.autodata-group.com/w1/manufacturers/$manufacturer/$body/engines?manufacturer=$manufacturer&body=$body&module=$module&litres=$litres&fuel=$fuel&freetext=$freetext&vehicletype=$vehicletype";
//                        dd($query_url);
//                        foreach ($post_data as $get_name => $get) {
//                            $query .= ""
//                        }
//                        $url = 'https://workshop.autodata-group.com/w1/manufacturers/' . $post_data['manufacturer'] . '/' . $post_data['body'] . '/engines/codes';
//                        $url2 = 'https://workshop.autodata-group.com/w1/manufacturers/ALF0/3000007/engines?manufacturer=ALF0&body=3000007&module=TD&litres=1%2C4&fuel=P&freetext=&vehicletype=1';
//
//                        $this->getData($url, $this->last_url, $post_data);
//                        dd($this->data);
//                        $this->getXPath();
//                        $codes = $this->xpath->query(".//tbody/tr");
//                        foreach ($codes as $key => $code) {
//                            $j = $key + 1;
////                            $engine_model_name = trim($name->nodeValue);
////                            dd($engine_model_name);
//                            $attr_path = "(.//tbody/tr)[$j]/attribute::*";
//                            $options_path = "(.//tbody/tr)[$j]//td";
//                            $attributes = $this->xpath->query($attr_path);
//                            $options = $this->xpath->query($options_path);
////                            dd($options);
//                            foreach ($attributes as $attribute) {
//                                $attribute_name = trim($attribute->nodeName);
//                                $attribute_value = trim($attribute->nodeValue);
//                                $post[$attribute_name] = $attribute_value;
//                            }
//                            foreach ($options as $opt_key => $opt) {
////                                dd($opt_key);
////                                $attribute_name = trim($attribute->nodeName);
//                                $option_value = trim($opt->nodeValue);
//                                $parameters[$opt_key] = preg_replace_callback('/\\\\u([0-9a-fA-F]{4})/', function ($match) {
//                                    return mb_convert_encoding(pack('H*', $match[1]), 'UTF-8', 'UCS-2BE');
//                                }, $option_value);
////                                $parameters[$opt_key] = iconv('UTF-8', 'WINDOWS-1251//IGNORE', $option_value);
//                            }
//
//                            unset($post['class']);
//                            unset($post['onclick']);
//                            unset($post['enginesubmit']);
//                            unset($post['return']);
//                            unset($post['false']);
////                            dd($post);
//                            $engine[$key]['post_data'] = $post;
//                            $engine[$key]['parameters'] = $parameters;
//                            $model[$i]['engines'][$model_engine][] = $engine[$key];
//                            $result[$k] = $model;
//                            $this->objectToTempFile($result[$k], $filename);
//                            dd($engine);
//                        }
//                        
//                        dd($engine);
//                        
//                        dd($this->data);
//                    dd($result);
//                    $this->getXPath();
//                    $names = $this->xpath->query($this->paths['engine_model_name']);
//                    foreach ($names as $key => $name) {
//                        $j = $key + 1;
//                        $engine_model_name = trim($name->nodeValue);
////                        dd($engine_model_name);
//                        $attr_path = "(.//a[@class='engine-code-link'])[$j]/attribute::*";
////                        dd($attr_path);
//                        $attributes = $this->xpath->query($attr_path);
//
//                        foreach ($attributes as $attribute) {
//                            $attribute_name = trim($attribute->nodeName);
//                            $attribute_value = trim($attribute->nodeValue);
//                            $post['post_data'][$attribute_name] = $attribute_value;
//                        }
//                        unset($post['post_data']['class']);
//                        unset($post['post_data']['href']);
////                            $model[$i][$engine_model_name] = $post;
//                        $model[$i]['engines'][$engine_model_name] = $post;
//                        $result[$k] = $model;
//                    }
//                }
//            }
//            $this->objectToFile($result, 'storage/temp/engines.txt');
//            $this->objectToFile($result, 'storage/temp/engines_models_3.txt');
//            $engines = $autodata->getEngines($array);
//            $this->getData('http://arts.restshot.ru/login');
//            $this->getParseAttributes($this->paths);
//            dump($result);
        } elseif (stripos($this->type, 'logout') > 0) {
//            dd('outoutout');
            $this->getData('https://workshop.autodata-group.com/user/logout', 'https://workshop.autodata-group.com/node');
            if (preg_match("/успешно/i", $this->data)) {
                return 'Успешно вышли из системы!';
            } else {
                return 'Возможно, возникли ошибки при выходе из системы!';
            }
//            dd($this->data);
        }
        $this->curlClose();

//        $autodata = new Autodata();
//        $autodata->getHiddenKeys();
    }

}
