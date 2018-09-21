@extends('admin.layouts.admin')

@section('content')

@component('admin.components.breadcrumbs')
@slot('title') Парсер Кинопоиск актеры @endslot
@slot('parent') Главная @endslot
@slot('parser') Парсер @endslot
@slot('kinopoisk') Кинопоиск @endslot
@slot('active') Актеры @endslot
@endcomponent

<form action="{{route('admin.parser.start')}}" method="post" enctype="multipart/form-data">
	{{ csrf_field() }}
	
	@include('admin.parser.kinopoisk.person.form')
	<input type="hidden" name="created_by" value="{{Auth::id()}}"/>
	<input type="hidden" name="type_parser" value="KinopoiskPerson"/>
</form>

@endsection
