<?php

namespace App\Http\Controllers;
//use App\Services\Parser\Parser;


use App\Country;
use App\Genre;
use App\Movie;
use App\Person;
use App\Type;

//use Illuminate\Support\Carbon;
//use App\Http\Resources\Movie as MovieResource;
//use Illuminate\Http\Request;

class BlogController extends Controller
{

    public function index()
    {
        $films = Type::where('title', 'фильмы')->first();
        $serials = Type::where('title', 'сериалы')->first();
        return view('frontend.index', [
            'films' => $films->movies()->where('published', 1)->orderBy('premiere', 'desc')->take(18)->get(),
            'serials' => $serials->movies()->where('published', 1)->orderBy('premiere', 'desc')->take(18)->get(),
        ]);
    }

    public function type($type_slug)
    {
        $type = Type::where('slug', $type_slug)->first();
        $genres = Genre::whereHas('movies', function ($query) use ($type) {
                    $query->where('type_id', $type->id);
                })
//                ->with('movies')
//                ->whereType($type_slug)
                ->where('published', 1)
                ->get();
//        dd($genres[0]->with('types')->get());

        return view('frontend.type.type', [
            'type' => $type,
            'movies' => $type->movies()->where('published', 1)->orderBy('created_at', 'desc')->paginate(15),
            'genres' => $genres,
        ]);
    }

    public function genre($type_slug, $genre_slug)
    {
        $type = Type::whereSlug($type_slug)->first();
        $genre = Genre::whereSlug($genre_slug)->first();
        $genres = Genre::whereHas('movies', function ($query) use ($type) {
                    $query->where('type_id', $type->id);
                })
                ->where('published', 1)
                ->get();
        $movies = $genre->movies()
                ->where('type_id', $type->id)
                ->where('published', 1)
                ->orderBy('created_at', 'desc')
                ->paginate(15);

        return view('frontend.genre.genre', [
            'type' => $type,
            'genre' => $genre,
            'genres' => $genres,
            'movies' => $movies,
            'genre_slug' => $genre_slug,
        ]);
    }

    public function video($video_slug)
    {
        
        $movie = Movie::where('slug', $video_slug)
                ->with('type')
                ->with('countries')
                ->with('actors')
                ->with('directors')
                ->with('genres')
                ->where('published', 1)
                ->first();
//        dd($movie);

        return view('frontend.movie.movie', [
            'movie' => $movie,
//            'premiere' => \Carbon\Carbon::parse($movie->premiere)->format('Y'),
//            'actors' => $movie->actors()->get(),
//            'directors' => $movie->directors()->get(),
//            'genres' => $movie->genres()->get(),
//            'countries' => $movie->countries()->get(),
        ]);
    }

    public function person($person_slug)
    {
        $person = Person::where('slug', $person_slug)
                ->with('countryBirth')
                ->with('professions')
                ->where('published', 1)
                ->first();
//        $fullname = $person->firstname . ' ' . $person->lastname;

        $actor_movie = Movie::whereHas('actors', function ($query) use ($person_slug) {
                    $query->where('slug', $person_slug);
                })
                ->where('published', 1)
                ->orderBy('premiere', 'desc')
                ->get();

        $director_movie = Movie::whereHas('directors', function ($query) use ($person_slug) {
                    $query->where('slug', $person_slug);
                })
                ->where('published', 1)
                ->orderBy('premiere', 'desc')
                ->get();

        $director_genre = Genre::whereHas('movies', function ($query) use ($person_slug) {
                    $query->whereHas('directors', function ($query) use ($person_slug) {
                        $query->where('slug', $person_slug);
                    });
                })->get();

        $actor_genre = Genre::whereHas('movies', function ($query) use ($person_slug) {
                    $query->whereHas('actors', function ($query) use ($person_slug) {
                        $query->where('slug', $person_slug);
                    });
                })->get();

        $genres = $actor_genre->merge($director_genre)->unique();

        return view('frontend.person.person', [
            'person' => $person,
//            'fullname' => $fullname,
            'birth_date' => \Carbon\Carbon::parse($person->birth_date)->format('d F Y'),
//            'professions' => $person->professions()->get(),
            'actor_movie' => $actor_movie,
            'director_movie' => $director_movie,
            'genres' => $genres,
        ]);
    }

    public function country($country_slug)
    {
        $countries = Country::where('published', 1)->orderBy('title')->get();
        $country = Country::where('slug', $country_slug)
                ->where('published', 1)
                ->first();
        return view('frontend.country.country', [
            'countries' => $countries,
            'country' => $country,
            'country_slug' => $country_slug,
            'movies' => $country->movies()->where('published', 1)->orderBy('created_at', 'desc')->paginate(15),
        ]);
    }

}
