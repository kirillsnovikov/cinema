@extends('layouts.app')

@section('title', $country->title . ' - CCO.CC')

@section('content')
<div class="main-content">
    <h1>{{$country->title}}</h1>
    <div class="right-sidebar">
        @include('frontend.country.particles.content')
        @include('frontend.country.particles.sidebar')
    </div>
</div>
@endsection

