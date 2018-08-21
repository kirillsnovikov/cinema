@extends('admin.layouts.admin')

@section('content')
@component('admin.components.breadcrumbs')
@slot('title') Парсер @endslot
@slot('parent') Главная @endslot
@slot('active') Парсер @endslot
@endcomponent
<a href="{{route('admin.parser.kinopoisk.index')}}" class="btn btn-outline-success btn-lg">Парсер Кинопоиск</a>
@endsection
