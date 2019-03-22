@extends('layouts.app')

@section('title', $person->meta_title)
@section('meta_title', $person->meta_title)
@section('meta_keyword', $person->meta_keyword)
@section('meta_description', $person->meta_description)

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <h1>{{$fullname}}</h1>
            <p class="text-muted h3">{{title_case($person->name_en)}}</p>
        </div>
        <div class="col-4">
            <img src="https://loremflickr.com/300/400/face/?random={{$person->image}}" class="img-fluid" alt="Фото {{$fullname}}" title="Фото {{$fullname}}" />
        </div>
        <div class="col-8">
            <table class="table table-bordered">
                <tbody>
                    <tr>
                        <th scope="row">Профессии</th>
                        <td>
                            /////
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">Рост</th>
                        <td>{{$person->tall / 100}} м</td>
                    </tr>
                    <tr>
                        <th scope="row">Дата рождения</th>
                        <td>{{$birth_date}}</td>
                    </tr>
                    <tr>
                        <th scope="row">Место рождения</th>
                        <td>
                            <a href="{{route('country', $person->countryBirth->slug)}}">{{$person->countryBirth->title}}</a>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">Жанры</th>
                        <td>
                            /////
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="col-12 d-flex flex-wrap mt-3">
        </div>
        <hr>
        <p class="p-3">{{$person->description}}</p>
    </div>
</div>
@endsection
