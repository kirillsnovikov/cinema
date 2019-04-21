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
//        dd($inputs);
        $parser->start($inputs);
        return redirect()
                        ->route('admin.parser.index')
                        ->with('success', 'Парсинг успешно завершен!');

    }

    public function checkProxy(Request $request, Parser $parser)
    {
        $inputs = $request->all();
        $parser->checkProxy($inputs);
    }

}
