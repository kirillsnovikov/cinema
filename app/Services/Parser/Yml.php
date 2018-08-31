<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Services\Yml;

use DOMImplementation;

/**
 * Description of Yml
 *
 * @author KNovikov
 */
class Yml
{

    public function __construct()
    {
        $this->createYml();
    }

    public function createYml()
    {
        //разбираем файл в массив
        $products = $this->trim('storage/temp/result_teestore2.txt');
        //список категорий
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
        }
    }

    public function trim($file)
    {
        return file($file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    }

}
