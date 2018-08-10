@extends('admin.layouts.admin')

@section('content')

@component('admin.components.breadcrumbs')
	@slot('title') Запуск парсинга @endslot
	@slot('parent') Парсер @endslot
	@slot('active') Создание @endslot
@endcomponent

<form action="{{route('admin.parser.start')}}" method="post" enctype="multipart/form-data">
	{{ csrf_field() }}
	
	@include('admin.parser.particles.form')
	<input type="hidden" name="created_by" value="{{Auth::id()}}"/>
</form>

@endsection
