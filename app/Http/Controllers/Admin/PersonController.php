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

        $image = $request->file('image');

        if ($image) {

            $image_name = Str::slug($person->firstname . ' ' . $person->lastname . ' ' . $person->id, '_');
            $image_ext = $image->getClientOriginalExtension();
            $image_new_name = $image_name . '.' . $image_ext;

            $save_image = Storage::putFileAs('public/person/', $image, $image_new_name);

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
    public function update(Request $request, Person $person)
    {
        $person->update($request->except('slug'));

        $person->professions()->detach();

        if ($request->input('professions')) :
            $person->professions()->attach($request->input('professions'));
        endif;

        $image = $request->file('image');

        if ($image) {

            $image_name = Str::slug($person->firstname . ' ' . $person->lastname . ' ' . $person->id, '_');
            $image_ext = $image->getClientOriginalExtension();
            $image_new_name = $image_name . '.' . $image_ext;
            $image_old_name = $person->image_name . '.' . $person->image_ext;

            if ($person->image_name && $person->image_ext) {
                Storage::delete('public/person/' . $image_old_name);
            }

            $save_image = Storage::putFileAs('public/person/', $image, $image_new_name);

            $person_image = Person::find($person->id);
            $person_image->image_name = $image_name;
            $person_image->image_ext = $image_ext;
            $person_image->save();
        }

        return redirect()->route('admin.person.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Person  $person
     * @return \Illuminate\Http\Response
     */
    public function destroy(Person $person)
    {
        $person->professions()->detach();
        $person->delete();
        $image_old_name = $person->image_name . '.' . $person->image_ext;

        if ($person->image_name && $person->image_ext) {
            Storage::delete('public/person/' . $image_old_name);
        }

        return redirect()->route('admin.person.index');
    }

}
