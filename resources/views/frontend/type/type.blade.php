@extends('layouts.app')

@section('title', $type->title . ' - ' . config('app.name', 'Cinema'))

@section('content')
<div class="main-content">
    <h1>{{$type->title}}</h1>
    <div class="right-sidebar">
        @include('frontend.type.particles.content')
        @include('frontend.type.particles.sidebar')
    </div>
</div>
@endsection

