@extends('layouts.app')

@section('title', 'Он-лайн сервис просмотра фильмов в хорошем качестве FullHD, HD720, HD1080')
@section('meta_title', 'Новинки лучших фильмов и сериалов смотреть он-лайн в хорошем качестве')
@section('meta_keyword', 'Фильмы онлайн, сериалы онлайн, новинки кино, онлайн бесплатно, в хорошем качестве, HD1080, HD720, FullHD')
@section('meta_description', 'Описание главной страницы')

@section('content')

<big-swiper-component></big-swiper-component>
<div class="main-content">
    <h1>Он-лайн сервис просмотра фильмов в хорошем качестве FullHD, HD720, HD1080' {{ config('app.name', 'Cinema') }}</h1>
    <h2 class="col-12">Новинки фильмов 2018-2019</h2>
    <swiper-component :videos="{{json_encode($films)}}" :route="{{json_encode(route('video'))}}"></swiper-component>
    <h2 class="col-12">Новинки сериалов 2018-2019</h2>
    <swiper-component :videos="{{json_encode($serials)}}" :route="{{json_encode(route('video'))}}"></swiper-component>
</div>

@endsection
