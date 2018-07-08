<?php

namespace App\Http\Controllers;

use App\Genre;
use App\Movie;
use Illuminate\Http\Request;

class BlogController extends Controller
{

    public function genre($slug)
    {
        $genre = Genre::where('slug', $slug)->first();

        return view('blog.genre', [
            'genre' => $genre,
            'movies' => $genre->movies()->where('published', 1)->paginate(12)
        ]);
    }

    public function movie($slug)
    {
        return view('blog.movie', [
            'movie' => Movie::where('slug', $slug)->first()
        ]);
    }

}
