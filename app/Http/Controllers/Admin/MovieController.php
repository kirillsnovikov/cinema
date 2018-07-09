<?php

namespace App\Http\Controllers\Admin;

use App\Movie;
use App\Genre;
use App\Country;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

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
            'movies' => Movie::orderBy('created_at', 'desc')->paginate(10),
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
            'genres' => Genre::with('children')->where('parent_id', '0')->get(),
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
    public function store(Request $request)
    {
        $movie = Movie::create($request->all());

        if ($request->input('genres')) :
            $movie->genres()->attach($request->input('genres'));
        endif;

        if ($request->input('countries')) :
            $movie->countries()->attach($request->input('countries'));
        endif;
        //dd($_POST);

        $image = $request->file('image');

        if ($image) {
            //$full_image_name = explode('.', $image->getClientOriginalName());
            $image_name = Str::slug($movie->title . ' ' . $movie->id, '_');
            $image_ext = $image->getClientOriginalExtension();

            $save_image = Storage::putFileAs('public/poster', $image, $image_name . '.' . $image_ext);


            $movie_image = Movie::find($movie->id);
            $movie_image->image_name = $image_name;
            $movie_image->image_ext = $image_ext;
            $movie_image->save();
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
            'genres' => Genre::with('children')->where('parent_id', '0')->get(),
            'countries' => Country::all(),
            'delimiter' => ''
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Movie  $movie
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Movie $movie)
    {
        $movie->update($request->except('slug'));

        $movie->genres()->detach();
        if ($request->input('genres')) :
            $movie->genres()->attach($request->input('genres'));
        endif;

        if ($request->input('countries')) :
            $movie->countries()->attach($request->input('countries'));
        endif;

        $image = $request->file('image');

        if ($image) {

            Storage::delete('public/poster/' . $movie->image_name . '.' . $movie->image_ext);

            $image_name = Str::slug($movie->title . ' ' . $movie->id, '_');
            $image_ext = $image->getClientOriginalExtension();

            $save_image = Storage::putFileAs('public/poster/', $image, $image_name . '.' . $image_ext);

            $movie_image = Movie::find($movie->id);
            $movie_image->image_name = $image_name;
            $movie_image->image_ext = $image_ext;
            $movie_image->save();
        }

        return redirect()->route('admin.movie.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Movie  $movie
     * @return \Illuminate\Http\Response
     */
    public function destroy(Movie $movie)
    {
        $movie->genres()->detach();
        $movie->delete();
        Storage::delete('public/poster/' . $movie->image_name . '.' . $movie->image_ext);

        return redirect()->route('admin.movie.index');
    }

}
