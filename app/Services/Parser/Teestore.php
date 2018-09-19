<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Services\Parser;

use DOMImplementation;

/**
 * Description of Teestore
 *
 * @author KNovikov
 */
class Teestore
{

    public function createYml()
    {
        $products = $this->trim('storage/temp/result_teestore2.txt');
        $cat_list = [
            'Футболки', 'Майки', 'Лонгсливы', 'Регланы'
        ];

        $imp = new DOMImplementation;

// Создает экземпляр класса DOMDocumentType
        $dtd = $imp->createDocumentType('yml_catalog', '', 'shops.dtd');

// Создает объект DOMDocument
        $dom = $imp->createDocument("", "", $dtd);

// Установка других параметров
        $dom->encoding = 'UTF-8';

// Создание основных элементов
        $yml_catalog = $dom->createElement('yml_catalog');
        $yml_catalog->setAttribute('date', '2018-08-31 16:02'); //добавить ф-ю генерирующую время и обновлять дату динамически
        //создание элементов

        $shop = $dom->createElement('shop');
        $name = $dom->createElement('name', 'Teestore');
        $company = $dom->createElement('company', 'Teestore');
        $url = $dom->createElement('url', 'https://teestore.ru/');
        $currencies = $dom->createElement('currencies');
        $currency = $dom->createElement('currency');
        $currency->setAttribute('id', 'RUR');
        $currency->setAttribute('rate', '1');
        $currency->setAttribute('plus', '0');
        $categories = $dom->createElement('categories');
        $local_delivery_cost = $dom->createElement('local_delivery_cost', '300');
        $offers = $dom->createElement('offers');

        //назначение дочерних элементов по отношению друг к другу для создания структуры файла


        $dom->appendChild($yml_catalog);
        $yml_catalog->appendChild($shop);
        $shop->appendChild($name);
        $shop->appendChild($company);
        $shop->appendChild($url);
        $shop->appendChild($currencies);
        $shop->appendChild($categories);
        $shop->appendChild($local_delivery_cost);
        $shop->appendChild($offers);
        $currencies->appendChild($currency);


        for ($i = 0; $i < count($cat_list); $i++) {
            $id = $i + 1; // id-категории
            $category = $dom->createElement('category', $cat_list[$i]); // Создаём узел
            $category->setAttribute('id', $id); // Устанавливаем атрибут "id" у узла
            $categories->appendChild($category); // Добавляем в корневой $categories
        }

        $result = [];
        for ($i = 0; $i < count($products); $i++) {
//            разбираем строку в массив
            $parameters = explode(';', $products[$i]);

            if (!in_array($parameters[3], $result)) {


                if (preg_match('/футб/', $parameters[5])) {
                    $category_id = '1';
                } elseif (preg_match('/майк/', $parameters[5])) {
                    $category_id = '2';
                } elseif (preg_match('/лонг/', $parameters[5])) {
                    $category_id = '3';
                } elseif (preg_match('/регл/', $parameters[5])) {
                    $category_id = '4';
                }

                //создание элементов товара

                $offer = $dom->createElement('offer');
                $offer->setAttribute('id', $parameters[0]);
                $offer->setAttribute('available', 'true');
                $url2 = $dom->createElement('url', $parameters[3]);
                $name = $dom->createElement('name', $parameters[5]);
                $picture = $dom->createElement('picture', $parameters[9]);
                $price = $dom->createElement('price', $parameters[7]);
                $currency_id = $dom->createElement('currencyId', 'RUR');
                $category_id = $dom->createElement('categoryId', $category_id);
                $delivery = $dom->createElement('delivery', 'true');

                //назначение дочерних элементов товара

                $offer->appendChild($url2);
                $offer->appendChild($name);
                $offer->appendChild($picture);
                $offer->appendChild($price);
                $offer->appendChild($currency_id);
                $offer->appendChild($category_id);
                $offer->appendChild($delivery);
                $offers->appendChild($offer);

                $result[] = $parameters[3];
            }



//            $id = $parameters[0];
//            $link = $parameters[3];
//            $name = $parameters[5];
//            $picture = $parameters[9];
//            $cost = $parameters[7];
            //dd($name);
        }
//        $category = $dom->createElement('category', 'Футболки');
//        $category = $dom->createElement('category', 'Майки');
//        $category->setAttribute('id', '1');
//        $category->setAttribute('id', '2');
// Добавление основного элемента
//        $categories->appendChild($category);
// Получение и печать документа
        $dom->save('storage/temp/yml_test.xml');
        dd($result);


//        foreach ($products as $product) {
//            $parameters = explode(';', $product);
//            dd($parameters);
//            
//        }
//        dd($products);
    }

    public function getTeestoreUrls()
    {

        $this->mkdirTemp();
        $fp = fopen('storage/temp/teestore_urls.txt', "wb");
        //$fp = fopen(__DIR__ . '\\kinopoisk_urls.txt', "ab");
        for ($i = $this->inputs['id_from']; $i <= $this->inputs['id_to']; $i++) {
            $url_man = 'https://teestore.ru/m_tee/' . $i;
            $url_woman = 'https://teestore.ru/w_tee/' . $i;
            fwrite($fp, $url_man . PHP_EOL);
            fwrite($fp, $url_woman . PHP_EOL);
            $this->urls[] = $url_man;
            $this->urls[] = $url_woman;
        }
        fclose($fp);
        //dd($this->urls);
    }

    public function writeTeestoreResult($sizes, $i, $status, $buy, $link, $mfr, $title, $category, $price, $cy, $img, $description, $cond, $country, $fp)
    {
        foreach ($sizes as $size) {

            $result = [];

            $result[] = $i;
            $result[] = $status;
            $result[] = $buy;
            $result[] = $link;
            $result[] = $mfr;
            $result[] = $title;
            $result[] = $category;
            $result[] = $price;
            $result[] = $cy;
            $result[] = $img;
            $result[] = $description;
            $result[] = $size;
            $result[] = $cond;
            $result[] = $country;

            $string = implode(';', $result);
            //dd($string);

            fwrite($fp, $string . PHP_EOL);

            $i++;
        }
        return $i;
    }

    public function getTeestoreCardInfo()
    {
        $links = $this->trim('storage/temp/links_teestore_part2.txt');
        //dd($links);
//        $delimiter = ';';
        $status = 'В наличии';
        $buy = 'Нельзя';
        $mfr = 'teestore';
        $cat_man = 'Мужские футболки и майки';
        $cat_woman = 'Женские футболки и майки';
        $type_man = 'Мужская футболка ';
        $type_woman = 'Женская футболка ';
        $cy = 'RUR';
//        $desc = 'Мужская футболка с авторским принтом' . $title . '. Футболка сшивается вручную из выококачесвтенной ткани на основе хлопка с небольшим добавлением полиэстера, благодаря которому принт не выстирывается даже после 500 стирок. Ткань легкая и дышащая, без неприятного ощущения синтетики.';
        $cond = 'Необходима предоплата';
        $country = 'Россия';


        $fp = fopen('storage/temp/result_teestore.txt', "wb");
        $bad_fp = fopen('storage/temp/bad_result_teestore.txt', "ab");
        $i = 1;

        foreach ($links as $link) {
            $data = $this->getRealData($link);
//            dd($links[1]);
            $link_exp = explode('/', $link);
//            dd($link_exp);

            if ($data) {

                $dom = new DOMDocument;    //создаем объект
                $dom->loadHTML($data, LIBXML_NOERROR);
                $xpath = new DomXPath($dom);
                $paths = [];
                $paths[] = ".//h1";
                $paths[] = ".//a[@class='breadcrumb'][last()]";
                $paths[] = ".//div[@class='view_good']/img/@src";
                $desc_1 = 'с авторским принтом ';
                $desc_2 = ' сшивается вручную из выококачесвтенной ткани на основе хлопка с небольшим добавлением полиэстера, благодаря которому принт не выстирывается даже после 500 стирок. Ткань легкая и дышащая, без неприятного ощущения синтетики.';


                if (in_array('m_tee', $link_exp)) {
                    $sizes = ['XS', 'S', 'M', 'L', 'XL', '2XL', '3XL', '4XL', '5XL',];
                    $price = 1290;
                    $type = 'Мужская футболка ';
                    $result = $this->node($xpath, $paths);
                    if (!$result) {
                        fwrite($bad_fp, $link . ' - Спарсили пустые значения' . PHP_EOL);
                    }
                    $result_name = explode(' ', $result[0]);
                    $out = array_slice($result_name, 1);
                    $name = implode(' ', $out);
                    $img = $result[2];
                    $title = $type . $result[1] . ' ' . $name;
                    $description = $type . $desc_1 . $name . '. ' . $result_name[0] . $desc_2;
                    $i = $this->writeTeestoreResult($sizes, $i, $status, $buy, $link, $mfr, $title, $cat_man, $price, $cy, $img, $description, $cond, $country, $fp);
                } elseif (in_array('m_tan', $link_exp)) {
                    $sizes = ['XS', 'S', 'M', 'L', 'XL', '2XL', '3XL',];
                    $price = 990;
                    $type = 'Мужская майка ';
                    $result = $this->node($xpath, $paths);
                    if (!$result) {
                        fwrite($bad_fp, $link . ' - Спарсили пустые значения' . PHP_EOL);
                    }
                    $result_name = explode(' ', $result[0]);
                    $out = array_slice($result_name, 1);
                    $name = implode(' ', $out);
                    $img = $result[2];
                    $title = $type . $result[1] . ' ' . $name;
                    $description = $type . $desc_1 . $name . '. ' . $result_name[0] . $desc_2;
                    $i = $this->writeTeestoreResult($sizes, $i, $status, $buy, $link, $mfr, $title, $cat_man, $price, $cy, $img, $description, $cond, $country, $fp);
                } elseif (in_array('m_lon', $link_exp)) {
                    $sizes = ['XS', 'S', 'M', 'L', 'XL', '2XL', '3XL', '4XL', '5XL',];
                    $price = 1590;
                    $type = 'Мужской лонгслив ';
                    $result = $this->node($xpath, $paths);
                    if (!$result) {
                        fwrite($bad_fp, $link . ' - Спарсили пустые значения' . PHP_EOL);
                    }
                    $result_name = explode(' ', $result[0]);
                    $out = array_slice($result_name, 1);
                    $name = implode(' ', $out);
                    $img = $result[2];
                    $title = $type . $result[1] . ' ' . $name;
                    $description = $type . $desc_1 . $name . '. ' . $result_name[0] . $desc_2;
                    $i = $this->writeTeestoreResult($sizes, $i, $status, $buy, $link, $mfr, $title, $cat_man, $price, $cy, $img, $description, $cond, $country, $fp);
                } elseif (in_array('m_rag', $link_exp)) {
                    $sizes = ['XS', 'S', 'M', 'L', 'XL', '2XL', '3XL',];
                    $price = 1490;
                    $type = 'Мужской реглан ';
                    $result = $this->node($xpath, $paths);
                    if (!$result) {
                        fwrite($bad_fp, $link . ' - Спарсили пустые значения' . PHP_EOL);
                    }
                    $result_name = explode(' ', $result[0]);
                    $out = array_slice($result_name, 1);
                    $name = implode(' ', $out);
                    $img = $result[2];
                    $title = $type . $result[1] . ' ' . $name;
                    $description = $type . $desc_1 . $name . '. ' . $result_name[0] . $desc_2;
                    $i = $this->writeTeestoreResult($sizes, $i, $status, $buy, $link, $mfr, $title, $cat_man, $price, $cy, $img, $description, $cond, $country, $fp);
                } elseif (in_array('w_tee', $link_exp)) {
                    $sizes = ['XS', 'S', 'M', 'L', 'XL', '2XL', '3XL',];
                    $price = 1290;
                    $type = 'Женская футболка ';
                    $result = $this->node($xpath, $paths);
                    if (!$result) {
                        fwrite($bad_fp, $link . ' - Спарсили пустые значения' . PHP_EOL);
                    }
                    $result_name = explode(' ', $result[0]);
                    $out = array_slice($result_name, 2);
                    $name = implode(' ', $out);
                    $img = $result[2];
                    $title = $type . $result[1] . ' ' . $name;
                    $description = $type . $desc_1 . $name . '. ' . $this->mb_ucfirst($result_name[1]) . $desc_2;
                    $i = $this->writeTeestoreResult($sizes, $i, $status, $buy, $link, $mfr, $title, $cat_woman, $price, $cy, $img, $description, $cond, $country, $fp);
                } elseif (in_array('w_tan', $link_exp)) {
                    $sizes = ['XS', 'S', 'M', 'L', 'XL', '2XL',];
                    $price = 990;
                    $type = 'Женская майка ';
                    $result = $this->node($xpath, $paths);
                    if (!$result) {
                        fwrite($bad_fp, $link . ' - Спарсили пустые значения' . PHP_EOL);
                    }
                    $result_name = explode(' ', $result[0]);
                    $out = array_slice($result_name, 2);
                    $name = implode(' ', $out);
                    $img = $result[2];
                    $title = $type . $result[1] . ' ' . $name;
                    $description = $type . $desc_1 . $name . '. ' . $this->mb_ucfirst($result_name[1]) . $desc_2;
                    $i = $this->writeTeestoreResult($sizes, $i, $status, $buy, $link, $mfr, $title, $cat_woman, $price, $cy, $img, $description, $cond, $country, $fp);
                } elseif (in_array('w_lon', $link_exp)) {
                    $sizes = ['XS', 'S', 'M', 'L', 'XL', '2XL', '3XL',];
                    $price = 1590;
                    $type = 'Женский лонгслив ';
                    $result = $this->node($xpath, $paths);
                    if (!$result) {
                        fwrite($bad_fp, $link . ' - Спарсили пустые значения' . PHP_EOL);
                    }
                    $result_name = explode(' ', $result[0]);
                    $out = array_slice($result_name, 2);
                    $name = implode(' ', $out);
                    $img = $result[2];
                    $title = $type . $result[1] . ' ' . $name;
                    $description = $type . $desc_1 . $name . '. ' . $this->mb_ucfirst($result_name[1]) . $desc_2;
                    $i = $this->writeTeestoreResult($sizes, $i, $status, $buy, $link, $mfr, $title, $cat_woman, $price, $cy, $img, $description, $cond, $country, $fp);
                } elseif (in_array('w_rag', $link_exp)) {
                    $sizes = ['XS', 'S', 'M', 'L', 'XL', '2XL',];
                    $price = 1490;
                    $type = 'Женский реглан ';
                    $result = $this->node($xpath, $paths);
                    if (!$result) {
                        fwrite($bad_fp, $link . ' - Спарсили пустые значения' . PHP_EOL);
                    }
                    $result_name = explode(' ', $result[0]);
                    $out = array_slice($result_name, 2);
                    $name = implode(' ', $out);
                    $img = $result[2];
                    $title = $type . $result[1] . ' ' . $name;
                    $description = $type . $desc_1 . $name . '. ' . $this->mb_ucfirst($result_name[1]) . $desc_2;
                    $i = $this->writeTeestoreResult($sizes, $i, $status, $buy, $link, $mfr, $title, $cat_woman, $price, $cy, $img, $description, $cond, $country, $fp);
                } else {
                    echo 'Нет такого типа футболки!! <br>';
                    fwrite($bad_fp, $link . ' - Нет такого типа футболки' . PHP_EOL);
                }

                echo $i . ' - ' . $link . ' - OK!! <br>';
                ob_flush();
                flush();

//                $i++;
                //dd($name);
//                foreach ($paths as $key => $path) {
//                    $nodeList = $xpath->query($path);
//
//                    foreach ($nodeList as $node) {
//                        
//                    }
//                }
//
//
//                //$nodeList = $xpath->query($title);
//                foreach ($nodeList as $node) {
//                    // добавляем это чтото в массив в нужный ключ
//                    $value = trim($node->nodeValue);
//                    $val = explode(' ', $value);
//
//                    //dd(!in_array($link, $results));
//
//
//
//                    $results[] = $value;
//                    // fwrite($fp, $link . PHP_EOL);
//                    //dd($link);
//                }
//                dd($val);
//
//                if (count($xpath->query($error)) == 0) {
//                    $nodeList = $xpath->query($path);
//                    if (count($nodeList) > 0) {
//
//                        foreach ($nodeList as $node) {
//                            // добавляем это чтото в массив в нужный ключ
//                            $link = mb_strtolower(trim($node->nodeValue));
//                            //dd(!in_array($link, $results));
//
//                            if (!in_array($link, $results)) {
//                                $results[] = $link;
//                                fwrite($fp, $link . PHP_EOL);
//                            }
//                            //dd($link);
//                        }
//                        echo $url . ' OK <br>';
//
////                        dd($results);
//                    } else {
//                        echo $url . 'Нет ссылок <br>';
//                        fwrite($bad_fp, $url . ' - Нет ссылок' . PHP_EOL);
//                    }
//                    //dd($nodeList);
//                } else {
//                    echo $url . 'Ошибка 404 <br>';
//                    fwrite($bad_fp, $url . ' - Ошибка 404' . PHP_EOL);
//                }
            }

            //usleep(5000000);
        }
        echo '!!!END SUCCESS!!!';
        fclose($fp);
        fclose($bad_fp);
    }

    public function getTeestoreCardLink()
    {
//        $arr = [
//            'a', 'b', 'c', 'c', 'c', 'e', 'a'
//        ];
//        $result = array_unique($arr);
//        dd($result);
        $fp = fopen('storage/temp/links_teestore_part2.txt', "ab");
        $bad_fp = fopen('storage/temp/bad_links_teestore.txt', "ab");

        $results = $this->trim('storage/temp/links_teestore_part2.txt');
        //dd($results);
        foreach ($this->urls as $url) {
            $data = $this->getRealData($url);

            if ($data) {

                $dom = new DOMDocument;    //создаем объект
                $dom->loadHTML($data, LIBXML_NOERROR);
                $xpath = new DomXPath($dom);
                $path = ".//div[@class='types']/a/@href";
                $error = ".//div[@class='p404']";

                if (count($xpath->query($error)) == 0) {
                    $nodeList = $xpath->query($path);
                    if (count($nodeList) > 0) {

                        foreach ($nodeList as $node) {
                            // добавляем это чтото в массив в нужный ключ
                            $link = mb_strtolower(trim($node->nodeValue));
                            //dd(!in_array($link, $results));

                            if (!in_array($link, $results)) {
                                $results[] = $link;
                                fwrite($fp, $link . PHP_EOL);
                            }
                            //dd($link);
                        }
                        echo $url . ' OK <br>';

//                        dd($results);
                    } else {
                        echo $url . 'Нет ссылок <br>';
                        fwrite($bad_fp, $url . ' - Нет ссылок' . PHP_EOL);
                    }
                    //dd($nodeList);
                } else {
                    echo $url . 'Ошибка 404 <br>';
                    fwrite($bad_fp, $url . ' - Ошибка 404' . PHP_EOL);
                }
            }
            ob_flush();
            flush();
            //usleep(5000000);
        }
        echo '!!!END SUCCESS!!!';
        fclose($fp);
        fclose($bad_fp);
        //dd($results);
    }

}
