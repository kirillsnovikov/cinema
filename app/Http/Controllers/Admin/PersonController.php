<?php

namespace App\Http\Controllers\Admin;

use App\Person;
use App\Profession;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use App\Services\Image\Interfaces\ImageSaveInterface as Image;

class PersonController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.person.index', [
            'persons' => Person::orderBy('created_at', 'desc')->paginate(10),
            'created_by' => Person::with('userCreated'),
            'modified_by' => Person::with('userModified'),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.person.create', [
            'person' => [],
            'professions' => Profession::all(),
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
        $person = Person::create($request->all());
        $person->update($request->only('slug'));

        if ($request->input('professions')) :
            $person->professions()->attach($request->input('professions'));
        endif;

        $file = $request->file('image');
        if (isset($file)) {
            $image->imageSave($file, $person->id, 'Person', [150, 300]);
        }

        return redirect()->route('admin.person.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Person  $person
     * @return \Illuminate\Http\Response
     */
    public function show(Person $person)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Person  $person
     * @return \Illuminate\Http\Response
     */
    public function edit(Person $person)
    {
        return view('admin.person.edit', [
            'person' => $person,
            'professions' => Profession::all(),
            'delimiter' => ''
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Person  $person
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Person $person, Image $image)
    {
        $person->update($request->except('slug'));

        $person->professions()->detach();

        if ($request->input('professions')) :
            $person->professions()->attach($request->input('professions'));
        endif;

        $file = $request->file('image');
        if (isset($file)) {
            $image->imageSave($file, $person->id, 'Person', [150, 300]);
        }

        return redirect()->route('admin.person.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Person  $person
     * @return \Illuminate\Http\Response
     */
    public function destroy(Person $person, Image $image)
    {
        $image->imageDelete($person->id, 'Person');
        $person->professions()->detach();
        $person->delete();

        return redirect()->route('admin.person.index');
    }

}
