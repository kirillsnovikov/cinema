<?php

namespace App\Http\Controllers\Admin;

use App\Movie;
use App\Genre;
use App\Type;
use App\Country;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\Image\Interfaces\ImageSaveInterface as Image;

class MovieController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.movie.index', [
            'movies' => Movie::orderBy('id', 'desc')->paginate(10),
            'created_by' => Movie::with('userCreated'),
            'modified_by' => Movie::with('userModified'),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.movie.create', [
            'movie' => [],
            'genres' => Genre::all(),
            'types' => Type::all(),
            'countries' => Country::all(),
            'delimiter' => ''
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Image $image)
    {
        $movie = Movie::create($request->all());
        $movie->update($request->only('slug'));

        if ($request->input('types')) :
            $movie->types()->attach($request->input('types'));
        endif;
        
        if ($request->input('genres')) :
            $movie->genres()->attach($request->input('genres'));
        endif;

        if ($request->input('countries')) :
            $movie->countries()->attach($request->input('countries'));
        endif;

        $file = $request->file('image');
        if (isset($file)) {
            $image->imageSave($file, $movie->id, 'Movie', [150, 300]);
        }

        return redirect()->route('admin.movie.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Movie  $movie
     * @return \Illuminate\Http\Response
     */
    public function show(Movie $movie)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Movie  $movie
     * @return \Illuminate\Http\Response
     */
    public function edit(Movie $movie)
    {
        return view('admin.movie.edit', [
            'movie' => $movie,
            'genres' => Genre::all(),
            'types' => Type::all(),
            'countries' => Country::all(),
            'delimiter' => '',
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Movie  $movie
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Movie $movie, Image $image)
    {
        $movie->update($request->except('slug'));

        $movie->types()->detach();
        $movie->genres()->detach();
        $movie->countries()->detach();

        if ($request->input('types')) :
            $movie->genres()->attach($request->input('types'));
        endif;
        
        if ($request->input('genres')) :
            $movie->genres()->attach($request->input('genres'));
        endif;

        if ($request->input('countries')) :
            $movie->countries()->attach($request->input('countries'));
        endif;

        $file = $request->file('image');
        if (isset($file)) {
            $image->imageSave($file, $movie->id, 'Movie', [150, 300]);
        }

        return redirect()->route('admin.movie.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Movie  $movie
     * @return \Illuminate\Http\Response
     */
    public function destroy(Movie $movie, Image $image)
    {
        $image->imageDelete($movie->id, 'movie');
        $movie->types()->detach();
        $movie->genres()->detach();
        $movie->countries()->detach();
        $movie->delete();

        return redirect()->route('admin.movie.index');
    }

}
