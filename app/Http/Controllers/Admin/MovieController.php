<?php

namespace App\Http\Controllers\Admin;

use App\Movie;
use App\Genre;
use App\Country;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Services\Interfaces\ImageInterface as Image;

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
    public function store(Request $request, Image $image)
    {
        $movie = Movie::create($request->all());

        if ($request->input('genres')) :
            $movie->genres()->attach($request->input('genres'));
        endif;

        if ($request->input('countries')) :
            $movie->countries()->attach($request->input('countries'));
        endif;

        $file = $request->file('image');
//        $out = $interface->resize($image);


        if (isset($file)) {

            $image_name = Str::slug($movie->title . ' ' . $movie->id, '_');

            $result = $image->jpeg($file, $image_name, $movie->id);
            if (array_key_exists('errors', $result)) {
                return redirect()->back()->with('errors', $result['errors']);
            }


            $movie_image = Movie::find($movie->id);
            $movie_image->image_name = $image_name;
            $movie_image->image_ext = ceil($movie->id / 1000);
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

        $movie->genres()->detach();
        $movie->countries()->detach();
        if ($request->input('genres')) :
            $movie->genres()->attach($request->input('genres'));
        endif;

        if ($request->input('countries')) :
            $movie->countries()->attach($request->input('countries'));
        endif;

        $file = $request->file('image');
        if (isset($file)) {

            $image_name = Str::slug($movie->title . ' ' . $movie->id, '_');

            $image_old_name = $movie->image_name . '.' . $movie->image_ext;
            if ($movie->image_name && $movie->image_ext) {
                $image->delete($image_old_name, $movie->id);
            }
            $result = $image->resize($file, $image_name, $movie->id, 200);
            if (array_key_exists('errors', $result)) {
                return redirect()->back()->with('errors', $result['errors']);
            }

            $movie_image = Movie::find($movie->id);
            $movie_image->image_name = $image_name;
            $movie_image->image_ext = ceil($movie->id / 1000);
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
        $movie->countries()->detach();
        $movie->delete();
        $image_old_name = $movie->image_name . '.' . $movie->image_ext;

        if ($movie->image_name && $movie->image_ext) {
            Storage::delete('public/poster/' . $image_old_name);
        }

        return redirect()->route('admin.movie.index');
    }

}
