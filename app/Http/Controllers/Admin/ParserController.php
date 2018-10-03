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

    public function teestore()
    {
        return view('admin.parser.teestore.index');
    }

    public function kinopoisk()
    {
        return view('admin.parser.kinopoisk.index');
    }
    
    public function autodata()
    {
        return view('admin.parser.autodata.index');
    }

    public function createPerson()
    {
        return view('admin.parser.kinopoisk.person.create');
    }

    public function createMovie()
    {
        return view('admin.parser.kinopoisk.movie.create');
    }
    
    public function createAutodataLink()
    {
        return view('admin.parser.autodata.link.create');
    }
    
    public function createAutodataCard()
    {
        return view('admin.parser.autodata.card.create');
    }

    public function createProxy()
    {
        return view('admin.parser.proxy.create');
    }

    public function start(Request $request, Parser $parser)
    {
        $inputs = $request->all();
        $parser->start($inputs);
    }
    
    public function autodataLink(Request $request, Parser $parser)
    {
        $inputs = $request->all();
        $output = $parser->autodata($inputs);
//        dd($output);
        return view('admin.parser.autodata.link.create', compact('output'));
    }

    public function checkProxy(Request $request, Parser $parser)
    {
        $inputs = $request->all();
        $parser->checkProxy($inputs);
    }

    public function parser()
    {
        /**
         * получение данных вынес в отдельный метод
         * чтоб можно было легко юзать фейковые данные
         */
        ob_start();

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
                        $fp = fopen($full_path, "wb");

                        fwrite($fp, $image);
                        fclose($fp);
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
                }
            } else {
                echo '" || Донор: "' . $url . ' Ничего не спарсили' . '</br>';
            }
            ob_flush();
            flush();
        }
    }

}
