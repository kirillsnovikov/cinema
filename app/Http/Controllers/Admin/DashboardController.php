<?php

namespace App\Http\Controllers\Admin;

use App\Movie;
use App\Genre;
use App\Person;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{

    //Dashboard

    public function dashboard()
    {

        return view('admin.dashboard', [
            'genres' => Genre::lastGenres(5),
            'movies' => Movie::lastMovies(5),
            'persons' => Person::lastPersons(5),
            'count_genres' => Genre::count(),
            'count_movies' => Movie::count(),
            'count_persons' => Person::count(),
        ]);
    }

}
