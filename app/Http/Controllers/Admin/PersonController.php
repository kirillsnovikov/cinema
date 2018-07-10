<?php

namespace App\Http\Controllers\Admin;

use App\Person;
use App\Profession;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

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
    public function store(Request $request)
    {
        $person = Person::create($request->all());

        if ($request->input('professions')) :
            $person->professions()->attach($request->input('professions'));
        endif;

//        if ($request->input('countries')) :
//            $person->countries()->attach($request->input('countries'));
//        endif;
//        dd($_POST);

        $image = $request->file('image');

        if ($image) {
            //$full_image_name = explode('.', $image->getClientOriginalName());
            $image_name = Str::slug($person->firstname . ' ' . $person->lastname . ' ' . $person->id, '_');
            $image_ext = $image->getClientOriginalExtension();

            $save_image = Storage::putFileAs('public/person/', $image, $image_name . '.' . $image_ext);


            $person_image = Person::find($person->id);
            $person_image->image_name = $image_name;
            $person_image->image_ext = $image_ext;
            $person_image->save();
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
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Person  $person
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Person $person)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Person  $person
     * @return \Illuminate\Http\Response
     */
    public function destroy(Person $person)
    {
        //
    }

}
