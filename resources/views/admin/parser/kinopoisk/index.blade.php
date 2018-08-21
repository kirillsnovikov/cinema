@extends('admin.layouts.admin')

@section('content')
@component('admin.components.breadcrumbs')
@slot('title') Парсер Кинопоиск @endslot
@slot('parent') Главная @endslot
@slot('parser') Парсер @endslot
@slot('active') Кинопоиск @endslot
@endcomponent
<a href="{{route('admin.parser.kinopoisk.movie.create')}}" class="btn btn-outline-success btn-lg">Парсинг фильмов</a>
<a href="{{route('admin.parser.kinopoisk.person.create')}}" class="btn btn-outline-success btn-lg">Парсинг актеров</a>
@endsection