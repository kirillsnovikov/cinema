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
        $urls = [];
        
        for($i=750; $i<=1200; $i++){
			$urls[] = 'https://www.kinopoisk.ru/film/'.$i;
		}
		
		//dd($urls);
    	
    	foreach($urls as $url){
    		
			$data = $this->getRealData($url);
        
	        $encoding_list = [
	            'UTF-8', 'ASCII',
	            'ISO-8859-1', 'ISO-8859-2', 'ISO-8859-3', 'ISO-8859-4', 'ISO-8859-5',
	            'ISO-8859-6', 'ISO-8859-7', 'ISO-8859-8', 'ISO-8859-9', 'ISO-8859-10',
	            'ISO-8859-13', 'ISO-8859-14', 'ISO-8859-15', 'ISO-8859-16',
	            'Windows-1251', 'Windows-1252', 'Windows-1254',
	        ];
	        
	        $code = mb_convert_encoding($data, "UTF-8", $encoding_list);
	        //echo $code;
	        
	        $dom = new DOMDocument;    //создаем объект
	        $dom->loadHTML($data, LIBXML_NOERROR);
	        
	        /*print "LIBXML_VERSION:   ".LIBXML_VERSION."</br>";
	        print "LIBXML_ERR_FATAL:   ".LIBXML_ERR_FATAL."</br>";
	        print "LIBXML_ERR_WARNING:   ".LIBXML_ERR_WARNING."</br>";
	        print "LIBXML_ERR_ERROR:   ".LIBXML_ERR_ERROR."</br>";
	        print "LIBXML_ERR_NONE:   ".LIBXML_ERR_NONE."</br>";
	        print "LIBXML_NSCLEAN:   ".LIBXML_NSCLEAN."</br>";*/
	        
	        
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
	            self::KEY_IMAGE  => "(.//img[@itemprop='image']/@src)[1]",
	            self::KEY_ACTORS => ".//*[@itemprop='actors']/a",
	            self::KEY_GENRE  => ".//*[@itemprop='genre']/a",
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
	        //echo '<pre>', print_r($results), '</pre>';
	        // или так смотрим
	        //dd($results);
	        
	        
	        /**
	         * а дальше работаем с этими элементами в БД
	         * например:
	         */
			
			
			////////////////////////////////
			
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
							'parent_id' => 1,
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
	        		$image = file_get_contents($image_path);
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

					
				echo('ID записи: '.$article->id.'-');	
				}
			}
			///////////////////////////
			echo('donor_URL: '.$url.'</br>');
		}
    }
    
    /**
     * @return string
     */
    public function getData()
    {
        // можем вернуть реально полученные данные
        return $this->getRealData();
        // а можно подсунуть фейковые данные, закомментировав верхний return
        //return $this->getFakeData();
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
    public function getRealData($url)
    {
    	
    	$proxies = [
			'46.191.159.180:1080', '78.157.225.146:11246', '46.228.8.90:1080', '93.157.233.125:31778', '194.186.182.214:1080', '88.86.94.46:1080', '81.22.54.60:23749', '195.218.144.150:1080', '188.120.246.158:5678', '80.244.237.22:5555', '94.50.144.7:1080', '88.85.172.30:1080', '81.30.211.104:41423', '5.56.138.16:1080', '217.67.189.202:1080', '188.187.152.24:1080', '92.39.129.110:3128', '81.211.68.14:1080', '91.123.24.204:1080', '188.35.138.138:1080', '79.122.225.82:3128', '195.16.49.18:1080', '85.192.5.67:1080', '95.79.107.205:1080', '94.181.34.61:1080', '77.51.183.143:1080', '77.243.125.181:1080', '109.207.162.53:3128', '46.180.156.126:1080', '46.150.174.90:13311', '95.80.81.177:1080', '85.192.5.66:1080', '194.186.224.102:1080', '5.166.179.82:1080', '195.64.221.49:1080', '195.88.208.115:3129', '31.43.219.37:1080', '82.147.116.201:31359', '82.200.45.34:6363', '46.232.207.166:1080', '95.86.206.65:8080', '109.195.231.236:41599', '79.135.73.114:1080', '194.186.252.74:1080', '31.173.0.249:1488', '81.163.68.127:41538', '195.218.203.230:1080', '217.195.74.17:1080', '213.177.105.14:1080', '213.178.39.236:1080', '188.35.167.7:35618', '5.143.181.75:1080', '194.190.251.82:1080', '188.187.62.254:1080', '176.122.251.56:33077', '193.169.5.213:1080', '212.118.51.130:1080', '31.220.183.217:53356', '95.31.16.215:9999', '176.122.56.80:35114', '128.75.212.150:1080', '178.218.48.57:31618', '109.172.57.189:1080', '5.35.62.80:1080', '217.144.101.227:1080', '195.218.140.202:1080', '194.186.222.213:1080', '80.250.236.35:3128', '2.93.134.162:1080', '46.150.167.173:1080', '82.208.95.64:1080', '31.7.225.31:1080', '195.178.202.179:1080', '128.70.54.4:1080', '128.73.49.3:1080', '91.224.133.121:35618', '185.35.117.102:5070', '188.134.1.20:63756', '212.42.62.27:1080', '31.173.1.123:1488', '86.62.127.232:1080', '195.144.232.165:1080', '89.249.241.195:3128',
    	];
    		
		$steps = count($proxies);
    	$i = 0;
		$try = TRUE;
		
		while($try){
			
			$cookiefile = __DIR__.'\\cookie2.txt';
			$proxy = ($proxies[$i]) ? $proxies[$i] : null;

	        $headers = [
	        	'Accept: text/xml,application/xml,application/xhtml+xml,text/html;q=0.9,text/plain;q=0.8,image/png,*/*;q=0.5',
	            'Cache-Control: max-age=100',
	            'Connection: keep-alive',
	            'Keep-Alive: 300',
	            'Accept-Charset: ISO-8859-1,utf-8;q=0.7,*;q=0.7',
	            'X-Requested-With: XMLHttpRequest',
	        ];
	        
	        $ch = curl_init($url);
	        
	        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/66.0.3359.181 Safari/537.36');
	        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
			curl_setopt($ch, CURLINFO_HEADER_OUT, true);
	        curl_setopt($ch, CURLOPT_REFERER, 'http://www.google.com');
	        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
	        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	        curl_setopt($ch, CURLOPT_COOKIEJAR, $cookiefile);
	        curl_setopt($ch, CURLOPT_COOKIEFILE, $cookiefile);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
	        curl_setopt($ch, CURLOPT_HEADER, 0);
			curl_setopt($ch, CURLOPT_TIMEOUT, 15);
			curl_setopt($ch, CURLOPT_CONNECTTIMEOUT,10);
	        curl_setopt($ch, CURLOPT_PROXY, $proxy);
	        curl_setopt($ch, CURLOPT_HTTPPROXYTUNNEL, True);
	        curl_setopt($ch, CURLOPT_PROXYTYPE, CURLPROXY_SOCKS4);
	        
	        $data = curl_exec($ch);
	        //dd(strlen($data));
	        $http_code = curl_getinfo($ch, CURLINFO_RESPONSE_CODE);
	        $strlen_data = strlen($data);
	        
			curl_close($ch);

			$i++;
			$try = (($i < $steps) && ($http_code != 200) && ($strlen_data = 0));
		}
		return $data;
    }
}


