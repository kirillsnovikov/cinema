@extends('layouts.app')

@section('title', $person->meta_title)
@section('meta_title', $person->meta_title)
@section('meta_keyword', $person->meta_keyword)
@section('meta_description', $person->meta_description)

@section('content')
<div class="main-content">
    <div class="content-layout">
        <h1>{{$fullname}}</h1>
        <p class="title">{{title_case($person->name_en)}}</p>
        <div class="right-sidebar">
            @include('frontend.person.particles.content')
            @include('frontend.person.particles.sidebar')
        </div>
    </div>
</div>
@endsection


