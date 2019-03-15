<?php

namespace App\Http\Controllers\Admin;

use App\Genre;
use App\Type;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GenreController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.genre.index', ['genres' => Genre::orderBy('id', 'desc')->paginate(10)]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.genre.create', [
            'genre' => [],
            'types' => Type::all()
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
        $genre = Genre::create($request->all());

        if ($request->input('types')) :
            $genre->types()->attach($request->input('types'));
        endif;

        return redirect()->route('admin.genre.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Genre  $genre
     * @return \Illuminate\Http\Response
     */
    public function show(Genre $genre)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Genre  $genre
     * @return \Illuminate\Http\Response
     */
    public function edit(Genre $genre)
    {
        return view('admin.genre.edit', [
            'genre' => $genre,
            'types' => Type::all()
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Genre  $genre
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Genre $genre)
    {
        $genre->update($request->except('slug'));
        $genre->types()->detach();

        if ($request->input('types')) :
            $genre->types()->attach($request->input('types'));
        endif;

        return redirect()->route('admin.genre.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Genre  $genre
     * @return \Illuminate\Http\Response
     */
    public function destroy(Genre $genre)
    {
        $genre->movies()->detach();
        $genre->types()->detach();
        $genre->delete();
        return redirect()->route('admin.genre.index');
    }

}
