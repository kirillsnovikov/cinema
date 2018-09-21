@extends('admin.layouts.admin')

@section('content')

@component('admin.components.breadcrumbs')
@slot('title') Парсер Кинопоиск фильмы @endslot
@slot('parent') Главная @endslot
@slot('parser') Парсер @endslot
@slot('kinopoisk') Кинопоиск @endslot
@slot('active') Фильмы @endslot
@endcomponent

<form action="{{route('admin.parser.start')}}" method="post" enctype="multipart/form-data">
	{{ csrf_field() }}
	
	@include('admin.parser.kinopoisk.movie.form')
	<input type="hidden" name="created_by" value="{{Auth::id()}}"/>
        <input type="hidden" name="type_parser" value="KinopoiskMovie"/>
</form>

@endsection
