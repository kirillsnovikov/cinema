<?php

namespace App\Http\Controllers\Admin;

//use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Category;
use App\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
//use Illuminate\Contracts\Filesystem\Filesystem;
use DOMDocument;
use Illuminate\Support\Str;
//use DOMNodeList;
use DomXPath;
use App\Services\Parser\Interfaces\ParserInterface as Parser;

class ParserController extends Controller
{

    public function index()
    {
        return view('admin.parser.index');
    }

    public function kinopoisk()
    {
        return view('admin.parser.kinopoisk.index');
    }

    public function createPerson()
    {
        return view('admin.parser.kinopoisk.person.create');
    }

    public function createMovie()
    {
        return view('admin.parser.kinopoisk.movie.create');
    }

    public function start(Request $request, Parser $parser)
    {
        $inputs = $request->all();
        $parser->start($inputs);
        //return redirect()->route('admin.parser.upload')->with($inputs);
    }

//    public function upload($inputs)
//    {
//        dd($inputs);
//    }

    const KEY_TITLE = 'title';
    const KEY_DESCR = 'description';
    const KEY_IMAGE = 'image';
    const KEY_ACTORS = 'actors';
    const KEY_GENRE = 'genres';

    /**
     *
     */
    public function parser()
    {
        /**
         * получение данных вынес в отдельный метод
         * чтоб можно было легко юзать фейковые данные
         */
        ob_start();
        $urls = [];

        for ($i = 1600; $i <= 1650; $i++) {
            $urls[] = 'https://www.kinopoisk.ru/film/' . $i;
        }

        foreach ($urls as $url) {


            $data = $this->getRealData($url);

            if ($data) {
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

                /* print "LIBXML_VERSION:   ".LIBXML_VERSION."</br>";
                  print "LIBXML_ERR_FATAL:   ".LIBXML_ERR_FATAL."</br>";
                  print "LIBXML_ERR_WARNING:   ".LIBXML_ERR_WARNING."</br>";
                  print "LIBXML_ERR_ERROR:   ".LIBXML_ERR_ERROR."</br>";
                  print "LIBXML_ERR_NONE:   ".LIBXML_ERR_NONE."</br>";
                  print "LIBXML_NSCLEAN:   ".LIBXML_NSCLEAN."</br>"; */


                /* $errors = libxml_get_errors($data);
                  foreach ($errors as $error) {
                  echo display_xml_error($error);
                  } */


                $xpath = new DomXPath($dom);

                //////////////////////

                /**
                 * я сделал константы сразу для большего удобства
                 * они сверху
                 */
                $paths = [
                    self::KEY_TITLE => ".//h1[@itemprop='name']",
                    self::KEY_DESCR => ".//div[@itemprop='description']",
                    self::KEY_IMAGE => "(.//img[@itemprop='image']/@src)[1]",
                    self::KEY_ACTORS => ".//*[@itemprop='actors']/a",
                    self::KEY_GENRE => ".//*[@itemprop='genre']/a",
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
                if (!$results[self::KEY_TITLE]) {
                    echo '" || Донор: "' . $url . '" Ничего не спарсили' . '</br>';
                    $fp = fopen(__DIR__ . '\\errors.txt', "ab");

                    fwrite($fp, $url . PHP_EOL);
                    fclose($fp);
                }


                ////////////////////////////////

                foreach ($results[self::KEY_TITLE] as $title) {

                    //инициализируем массив в котором будут
                    //ID'шники категорий для связанной таблицы
                    $categories = [];


                    foreach ($results[self::KEY_GENRE] as $genre) {

                        //добавляем в массив значения ID у которых совпали названия
                        //если данного названия не существует в таблице категорий
                        //добавляем его и записываем в массив

                        if (!Category::where('title', $genre)->count()) {
                            $category = Category::create([
                                        'title' => $genre,
                                        'slug' => Str::slug(mb_substr($genre, 0, 40) . '-' . \Carbon\Carbon::now()->format('dmyHi'), '-'),
                                        'parent_id' => 1,
                                        'published' => 1,
                            ]);
                            $categories[] = $category->id;
                        } else {
                            $categories[] = Category::where('title', $genre)->first()->id;
                        }
                    }

                    //получаем картинку и помещаем её во временную папку `temp`
                    foreach ($results[self::KEY_IMAGE] as $image_path) {

                        $domain = 'https://ofx.to/';
                        $image_name = pathinfo($image_path, PATHINFO_FILENAME);
                        $image_ext = pathinfo($image_path, PATHINFO_EXTENSION);
                        $image_uniq_name = md5($image_name) . '.' . $image_ext;
                        $image = file_get_contents($image_path);
                        $full_path = public_path() . '\\storage\\poster\\' . $image_uniq_name;
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
                    if (!Article::where('title', $title)->count()) {
                        $description = ($results[self::KEY_DESCR]) ? $results[self::KEY_DESCR][0] : 'Пустой парсинг';
                        $article = Article::create([
                                    'title' => $title,
                                    'description' => $description,
                                    'slug' => Str::slug(mb_substr($results[self::KEY_TITLE][0], 0, 40) . '-' . \Carbon\Carbon::now()->format('dmyHi'), '-'),
                                    'image' => Storage::url('poster/' . $image_uniq_name),
                                    'published' => 1,
                        ]);
                        Article::find($article->id)->categories()->attach($categories);
                        echo 'ID in DB: "' . $article->id . '" || ';
                    }
                    echo 'Фильм: "' . $title . '" || Донор: "' . $url . '"</br>';
                    //ob_get_contents();
                    //dump();
                }
            } else {
                echo '" || Донор: "' . $url . ' Ничего не спарсили' . '</br>';
                //ob_get_contents();
            }



            /* $fp = fopen(__DIR__.'\\cookie2.txt', "wb");
              fwrite($fp, "");
              fclose($fp); */



            ob_flush();
            flush();
            //usleep(mt_rand(4000000, 7000000));
            ///////////////////////////
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
        $user_agents = [
            'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/66.0.3359.181 Safari/537.36', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:60.0) Gecko/20100101 Firefox/60.0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_13_4) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/66.0.3359.181 Safari/537.36', 'Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/66.0.3359.181 Safari/537.36', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/67.0.3396.87 Safari/537.36', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_13_4) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/11.1 Safari/605.1.15', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) HeadlessChrome/64.0.3282.119 Safari/537.36', 'Mozilla/5.0 (Windows NT 6.1; Win64; x64; rv:60.0) Gecko/20100101 Firefox/60.0', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:60.0) Gecko/20100101 Firefox/60.0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.13; rv:60.0) Gecko/20100101 Firefox/60.0', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/67.0.3396.79 Safari/537.36', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_13_5) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/11.1.1 Safari/605.1.15', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_12_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/66.0.3359.181 Safari/537.36', 'Mozilla/5.0 (X11; Linux x86_64; rv:60.0) Gecko/20100101 Firefox/60.0', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/67.0.3396.62 Safari/537.36', 'Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/67.0.3396.87 Safari/537.36', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/64.0.3282.140 Safari/537.36 Edge/17.17134', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/66.0.3359.139 Safari/537.36', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/66.0.3359.181 Safari/537.36', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_13_5) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/67.0.3396.87 Safari/537.36', 'Mozilla/5.0 (Windows NT 6.3; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/66.0.3359.181 Safari/537.36', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/58.0.3029.110 Safari/537.36 Edge/16.16299', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_13_3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/66.0.3359.181 Safari/537.36', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_11_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/66.0.3359.181 Safari/537.36', 'Mozilla/5.0 (Windows NT 6.1; WOW64; Trident/7.0; rv:11.0) like Gecko', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_13_4) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/66.0.3359.139 Safari/537.36', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_13_5) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/66.0.3359.181 Safari/537.36', 'Mozilla/5.0 (X11; Linux x86_64; rv:52.0) Gecko/20100101 Firefox/52.0', 'Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/66.0.3359.181 Safari/537.36', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/67.0.3396.62 Safari/537.36', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_12_6) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/11.1 Safari/605.1.15', 'Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/67.0.3396.79 Safari/537.36', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_13_4) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/67.0.3396.79 Safari/537.36', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_13_4) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/67.0.3396.87 Safari/537.36', 'Mozilla/5.0 (Windows NT 10.0; WOW64; Trident/7.0; rv:11.0) like Gecko', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_13_3) AppleWebKit/604.5.6 (KHTML, like Gecko) Version/11.0.3 Safari/604.5.6', 'Mozilla/5.0 (Windows NT 6.3; Win64; x64; rv:60.0) Gecko/20100101 Firefox/60.0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.12; rv:60.0) Gecko/20100101 Firefox/60.0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_12_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/67.0.3396.87 Safari/537.36', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_13_4) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/67.0.3396.62 Safari/537.36', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:59.0) Gecko/20100101 Firefox/59.0', 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/66.0.3359.181 Safari/537.36', 'Mozilla/5.0 (Windows NT 6.1; Win64; x64; rv:59.0) Gecko/20100101 Firefox/59.0', 'Mozilla/5.0 (compatible; MSIE 9.0; Windows NT 6.1; Trident/5.0;  Trident/5.0)', 'Mozilla/5.0 (iPad; CPU OS 11_3 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/11.0 Mobile/15E148 Safari/604.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:61.0) Gecko/20100101 Firefox/61.0', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/51.0.2704.106 Safari/537.36', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/66.0.3359.170 Safari/537.36 OPR/53.0.2907.68', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/66.0.3359.181 Chrome/66.0.3359.181 Safari/537.36', 'Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/67.0.3396.62 Safari/537.36', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/65.0.3325.181 Safari/537.36', 'Mozilla/5.0 (Windows NT 6.1; rv:52.0) Gecko/20100101 Firefox/52.0', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/67.0.3396.87 Safari/537.36', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_13_5) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/67.0.3396.79 Safari/537.36', 'Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/66.0.3359.139 Safari/537.36', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/67.0.3396.79 Safari/537.36', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/66.0.3359.139 Safari/537.36', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.11; rv:60.0) Gecko/20100101 Firefox/60.0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_12_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/66.0.3359.139 Safari/537.36', 'Mozilla/5.0 (Windows NT 10.0; WOW64; rv:60.0) Gecko/20100101 Firefox/60.0', 'Mozilla/5.0 (Windows NT 6.1; rv:60.0) Gecko/20100101 Firefox/60.0', 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:52.0) Gecko/20100101 Firefox/52.0', 'Mozilla/5.0 (compatible; MSIE 9.0; Windows NT 6.0; Trident/5.0;  Trident/5.0)', 'Mozilla/5.0 (iPad; CPU OS 11_4 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/11.0 Mobile/15E148 Safari/604.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_13_2) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/66.0.3359.181 Safari/537.36', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/65.0.3325.181 Safari/537.36', 'Mozilla/5.0 (Windows NT 6.3; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/67.0.3396.87 Safari/537.36', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:59.0) Gecko/20100101 Firefox/59.0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_12_6) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/11.1.1 Safari/605.1.15', 'Mozilla/5.0 (Windows NT 6.1; Win64; x64; rv:61.0) Gecko/20100101 Firefox/61.0', 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:60.0) Gecko/20100101 Firefox/60.0', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36 Edge/15.15063', 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/66.0.3359.181 Safari/537.36', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_11_6) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/11.1 Safari/605.1.15', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_11_6) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/11.1.1 Safari/605.1.15', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:57.0) Gecko/20100101 Firefox/57.0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_11_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/67.0.3396.87 Safari/537.36', 'Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/67.0.3396.87 Safari/537.36', 'Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/65.0.3325.181 Safari/537.36', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/66.0.3359.117 Safari/537.36', 'Mozilla/5.0 (X11; Linux x86_64; rv:61.0) Gecko/20100101 Firefox/61.0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.13; rv:59.0) Gecko/20100101 Firefox/59.0', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_13_5) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/67.0.3396.62 Safari/537.36', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/63.0.3239.132 Safari/537.36', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/66.0.3359.170 Safari/537.36', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/66.0.3359.170 Safari/537.36',
        ];

        $proxies = [
            '194.186.230.226:1080', '85.143.177.150:1080', '85.142.251.28:1080', '85.143.160.45:1080', '217.195.74.17:1080', '217.67.189.202:1080', '46.150.167.173:1080', '185.35.117.102:5070', '81.211.18.10:1080', '85.143.156.238:1080', '95.31.16.215:9999', '195.218.131.226:1080', '77.87.215.81:1080', '195.16.49.18:1080', '188.187.62.254:1080', '86.62.127.232:1080', '128.70.54.4:1080', '217.144.101.227:1080', '81.211.100.158:1080', '195.218.167.90:1080', '81.211.31.58:1080', '188.35.138.138:1080', '5.56.138.16:1080', '195.144.232.165:1080', '77.51.183.143:1080', '31.7.225.31:1080', '80.244.237.22:5555', '194.67.6.98:1080', '92.55.54.126:1080', '128.74.129.24:1080', '92.39.129.110:3128', '195.218.197.194:1080', '128.75.212.150:1080', '81.89.71.70:41443', '194.186.252.74:1080', '91.224.133.121:35618', '95.79.107.205:1080', '81.163.68.127:41538', '128.73.49.3:1080', '88.85.172.30:1080', '5.166.179.82:1080', '188.134.1.20:63756', '195.218.138.150:1080', '81.30.215.23:1080', '46.191.159.180:1080',
        ];

        //$steps = count($proxies);
        $i = 0;
        $try = TRUE;

        while ($try) {

            $cookiefile = __DIR__ . '\\cookie2.txt';
            $proxy = $proxies[mt_rand(0, count($proxies) - 1)];
            $user_agent = $user_agents[mt_rand(0, count($user_agents) - 1)];
            //($proxies[$i]) ? $proxies[$i] : null;

            $headers = [
                'Accept: text/xml,application/xml,application/xhtml+xml,text/html;q=0.9,text/plain;q=0.8,image/png,*/*;q=0.5',
                'Cache-Control: max-age=100',
                'Connection: keep-alive',
                'Keep-Alive: 300',
                'Accept-Charset: ISO-8859-1,utf-8;q=0.7,*;q=0.7',
                'X-Requested-With: XMLHttpRequest',
            ];

            $ch = curl_init($url);

            curl_setopt($ch, CURLOPT_USERAGENT, $user_agent);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLINFO_HEADER_OUT, true);
            curl_setopt($ch, CURLOPT_REFERER, 'https://www.kinopoisk.ru/film/');
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_COOKIEJAR, $cookiefile);
            curl_setopt($ch, CURLOPT_COOKIEFILE, $cookiefile);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_HEADER, 0);
            curl_setopt($ch, CURLOPT_TIMEOUT, 15);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
            curl_setopt($ch, CURLOPT_PROXY, $proxy);
            curl_setopt($ch, CURLOPT_HTTPPROXYTUNNEL, True);
            curl_setopt($ch, CURLOPT_PROXYTYPE, CURLPROXY_SOCKS4);

            $data = curl_exec($ch);
            $http_code = curl_getinfo($ch, CURLINFO_RESPONSE_CODE);
            $strlen_data = strlen($data);

            curl_close($ch);

            //$i++;
            $try = (($http_code != 200) && ($strlen_data == 0));
            //($i < $steps)
            //var_dump($data);
        }
        return $data;
        //usleep(5000000);
    }

}
