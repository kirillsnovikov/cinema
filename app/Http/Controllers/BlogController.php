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

    public function genre($param, $slug)
    {
//        $type = Type::whereSlug($param)->first();
        $genre = Genre::where('slug', $slug)->first();
//        $movies = Movie::with('types:slug')->get();
        $movies = Movie::whereHas('types', function ($query) use ($param) {
                    $query->where('slug', $param);
                })
                ->whereHas('genres', function ($query) use ($slug) {
                    $query->where('slug', $slug);
                })
                ->where('published', 1)
                ->orderBy('created_at', 'desc')
                ->paginate(12);
//        dd($movies);
//        $movies_type = $type->movies()->with('genres')->get();
//        $movies_type = $type->movies()->with('genres')->get()->has('genres', '=', $slug)->get();
//        dd($movies_type->has('genres', '=', $slug));
//        $movies = [];
//        foreach ($movies_type as $movie) {
//            if ($movie->genres->where('slug', $slug)->first() != null) {
//                $movies[] = $movie;
//            }
//
//
//
////            dd($movie->has('genres', '=', $slug)->get());
////            $movies[] = $movie->has('genres', '=', $slug);
//        }
//        dd($movies);
//        dd($movies[145]->types->where('slug', $param));
//        dd($type->movies()->where('published', 1)->get());

        return view('frontend.genre', [
            'genre' => $genre,
            'movies' => $movies
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
