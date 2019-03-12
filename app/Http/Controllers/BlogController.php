<?php

namespace App\Http\Controllers;

use App\Genre;
use App\Movie;
use App\Type;
//use App\Http\Resources\Movie as MovieResource;
//use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function index()
    {
        $films = Type::where('title', 'фильмы')->first();
        $serials = Type::where('title', 'сериалы')->first();
//        dd($genre->movies());
        return view('frontend.index', [
//            'movies' => Movie::where('published', 1)->orderBy('premiere', 'desc')->take(18)->get(),
//            'films' => $films->movies()->where('published', 1)->orderBy('premiere', 'desc')->paginate(18),
            'films' => $films->movies()->where('published', 1)->orderBy('premiere', 'desc')->take(18)->get(),
            'serials' => $serials->movies()->where('published', 1)->orderBy('premiere', 'desc')->take(18)->get(),
        ]);
    }
    
    
    public function type($slug)
    {
        $type = Type::where('slug', $slug)->first();
//        dd($type->genres()->get());
//        dd($genre->movies()->where('published', 1)->paginate(12));

        return view('frontend.type', [
            'type' => $type,
            'movies' => $type->movies()->where('published', 1)->orderBy('created_at', 'desc')->paginate(12),
            'genres' => $type->genres()->get()
        ]);
    }

    public function genre($slug)
    {
        $genre = Genre::where('slug', $slug)->first();
//        dd($genre->movies()->where('published', 1)->paginate(12));

        return view('frontend.genre', [
            'genre' => $genre,
            'movies' => $genre->movies()->where('published', 1)->paginate(12)
        ]);
    }

    public function movie($slug)
    {
        return view('frontend.movie', [
            'movie' => Movie::where('slug', $slug)->first(),
            'token' => config('services.moonwalk.token'),
        ]);
    }

}
