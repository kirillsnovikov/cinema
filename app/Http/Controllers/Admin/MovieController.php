<?php

namespace App\Http\Controllers\Admin;

use App\Movie;
use App\Genre;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

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
        //dd($_POST);

        if ($request->file('file')) {
            $file = Storage::putFileAs('public/images', $request->file('file'), time() . $request->file('file')->getClientOriginalName());
            dd($file);
            $articl = Movie::find($movie->id);
            $articl->image = asset(Storage::url($file));
            $articl->save();
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Movie  $movie
     * @return \Illuminate\Http\Response
     */
    public function destroy(Movie $movie)
    {
        //
    }

}
