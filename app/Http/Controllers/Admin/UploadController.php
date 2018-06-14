<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Category;
use App\Article;
use Illuminate\Support\Facades\Storage;
use Illuminate\Contracts\Filesystem\Filesystem;
use DOMDocument;
use Illuminate\Support\Str;
//use DOMNodeList;
use DomXPath;


class Title
{
    public static function create(array $values)
    {
    
    }
}

class UploadController extends Controller
{
    
    const KEY_TITLE  = 'title';
    const KEY_DESCR  = 'description';
    const KEY_IMAGE  = 'image';
    const KEY_ACTORS = 'actors';
    const KEY_GENRE  = 'genres';
    
    /**
     *
     */
    public function parser()
    {
        /**
         * получение данных вынес в отдельный метод
         * чтоб можно было легко юзать фейковые данные
         */
        $data = $this->getData();
        
        $encoding_list = [
            'UTF-8', 'ASCII',
            'ISO-8859-1', 'ISO-8859-2', 'ISO-8859-3', 'ISO-8859-4', 'ISO-8859-5',
            'ISO-8859-6', 'ISO-8859-7', 'ISO-8859-8', 'ISO-8859-9', 'ISO-8859-10',
            'ISO-8859-13', 'ISO-8859-14', 'ISO-8859-15', 'ISO-8859-16',
            'Windows-1251', 'Windows-1252', 'Windows-1254',
        ];
        
        $code = mb_convert_encoding($data, "UTF-8", "Windows-1251");
        //echo $code;
        
        $dom = new DOMDocument;    //создаем объект
        $dom->loadHTML($data, LIBXML_NOERROR);
        
        print "LIBXML_VERSION:   ".LIBXML_VERSION."</br>";
        print "LIBXML_ERR_FATAL:   ".LIBXML_ERR_FATAL."</br>";
        print "LIBXML_ERR_WARNING:   ".LIBXML_ERR_WARNING."</br>";
        print "LIBXML_ERR_ERROR:   ".LIBXML_ERR_ERROR."</br>";
        print "LIBXML_ERR_NONE:   ".LIBXML_ERR_NONE."</br>";
        print "LIBXML_NSCLEAN:   ".LIBXML_NSCLEAN."</br>";
        
        
        /*$errors = libxml_get_errors($data);
        foreach ($errors as $error) {
            echo display_xml_error($error);
        }*/
        
        
        $xpath = new DomXPath($dom);
        
        //////////////////////
        
        /**
         * я сделал константы сразу для большего удобства
         * они сверху
         */
        $paths = [
            self::KEY_TITLE  => ".//h1[@itemprop='name']",
            self::KEY_DESCR  => ".//div[@itemprop='description']",
            //self::KEY_IMAGE  => ".//*[@class='poster sscn relative']/img/@src",
            self::KEY_ACTORS => ".//li[@itemprop='actors']/a",
            //self::KEY_GENRE  => ".//*[@itemprop='genre']/a",
        ];
        
        /**
         * Инициализируем результирующий массив
         * в котором у нас будут все данные
         */
        $results = [];
        
        foreach ($paths as $name => $path) {
            
            /**
             * переименовал эту переменную из $val
             * переменные лучше сразу называть правильно
             * имя должно отражать содержание переменной
             * в дальнейшем будет меньше путаницы и больше понимаемости ;)
             */
            $nodeList = $xpath->query($path);
            
            /**
             * Инициализируем массив с этим ключём,
             * чтоб даже если будет !$val->length
             * чтоб хотя б пустой был
             */
            $results[$name] = [];
            
            if ($nodeList->length) {
                // тут что-то есть
                /** @var \DOMElement $node */
                foreach ($nodeList as $node) {
                    // добавляем это чтото в массив в нужный ключ
                    $results[$name][] = $node->nodeValue;
                }
            }
        }
		
		
        // смотрим результат
        echo '<pre>', print_r($results), '</pre>';
        // или так смотрим
        dump($results);
        
        
        /**
         * а дальше работаем с этими элементами в БД
         * например:
         */
		
		
		////////////////////////////////
		/*
        foreach($results[self::KEY_TITLE] as $title) {
        	
			//инициализируем массив в котором будут
			//ID'шники категорий для связанной таблицы
			$categories = [];
			
			
			foreach($results[self::KEY_GENRE] as $genre){
				
				//добавляем в массив значения ID у которых совпали названия
				//если данного названия не существует в таблице категорий
				//добавляем его и записываем в массив
				
				if(!Category::where('title', $genre)->count()) {
					$category = Category::create([
						'title' => $genre,
						'slug' => Str::slug( mb_substr($genre, 0, 40) . '-' . \Carbon\Carbon::now()->format('dmyHi'), '-'),
						'parent_id' => 0,
						'published' => 1,
					]);
					$categories[] = $category->id;
				} else {
					$categories[] = Category::where('title', $genre)->first()->id;
				}
			}
			
			//получаем картинку и помещаем её во временную папку `temp`
			foreach($results[self::KEY_IMAGE] as $image_path) {
				
				$domain = 'https://ofx.to/';
				$image_name = pathinfo($image_path, PATHINFO_FILENAME);
				$image_ext = pathinfo($image_path, PATHINFO_EXTENSION);
				$image_uniq_name = md5($image_name).'.'.$image_ext;
        		$image = file_get_contents($domain.$image_path);
        		$full_path = public_path().'\\storage\\poster\\'.$image_uniq_name;
        		//dd($temp_path);
        		//$temp_path = asset(storage_path('app'));
        		
        		
        		//dd($temp_path);
        		//$xportlist = stream_get_transports();
				//print_r($xportlist);
        		
        		//$fp = stream_socket_client ("tcp://cco.cc:80", $errno, $errstr, 30);
        		//dd($fp);
        		$fp = fopen($full_path, "wb");
        		
				fwrite($fp, $image);
				fclose($fp);
				//$adgg = Storage::url('poster/'.$image_uniq_name);
				//dd($adgg);
				//$real_path = public_path();
				//dd($real_path);
        		//Storage::move('http://cco.cc/storage/temp/493271.jpg', asset('storage/images/'.$image_name.'asdfasf'));
        		
			}
			
			//добавляем новую запись если она не существует
			if(!Article::where('title', $title)->count()) {
				$article = Article::create([
					'title' => $title,
					'description' => $results[self::KEY_DESCR][0],
					'slug' => Str::slug( mb_substr($results[self::KEY_TITLE][0], 0, 40) . '-' . \Carbon\Carbon::now()->format('dmyHi'), '-'),
					'image' => Storage::url('poster/'.$image_uniq_name),
					'published' => 1,
				]);
				Article::find($article->id)->categories()->attach($categories);

				
			echo($article->id);	
			}
		}*/
		///////////////////////////
    }
    
    /**
     * @return string
     */
    public function getData()
    {
        // можем вернуть реально полученные данные
        return $this->getRealData();
        // а можно подсунуть фейковые данные, закомментировав верхний return
        return $this->getFakeData();
    }
    
    /**
     * @return string
     */
    public function getFakeData()
    {
        // предварительно сохраняем html нужной страницы в файл
        $filename = '/path/to/file.html';
        // нужно это, чтоб при разработке лишний раз не терзать сервис и сеть
        return file_get_contents($filename);
    }
    
    /**
     * @return string
     */
    public function getRealData()
    {
        $urls = ['http://hello-site.ru/blog/',
            'http://hello-site.ru/web-notes/',
            'http://hello-site.ru/games/'];
            
        $cookiefile = __DIR__.'\\cookie.txt';
        
        $string  = 'https://www.kinopoisk.ru/film/prestizh-2006-195334/';
        $headers = ['Accept: Accept: text/xml,application/xml,application/xhtml+xml,text/html;q=0.9,text/plain;q=0.8,image/png,*/*;q=0.5',
            'Cache-Control: max-age=100',
            'Connection: keep-alive',
            'Keep-Alive: 300',
            'Accept-Charset: ISO-8859-1,utf-8;q=0.7,*;q=0.7',
            ];
        
        $ch = curl_init($string);
        
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/66.0.3359.181 Safari/537.36');
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_REFERER, 'http://www.google.com');
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1); 
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_COOKIEJAR, $cookiefile);
        curl_setopt($ch, CURLOPT_COOKIEFILE, $cookiefile);
        curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_TIMEOUT, 15); 
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT,10); 
        curl_setopt($ch, CURLOPT_PROXY, '176.122.251.56:33077');
        curl_setopt($ch, CURLOPT_HTTPPROXYTUNNEL, True);
        curl_setopt($ch, CURLOPT_PROXYTYPE, CURLPROXY_SOCKS4);
        
        $data = curl_exec($ch);
        curl_close($ch);
        
        return $data;
    }
}


