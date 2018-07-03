@extends('admin.layouts.admin')

@section('content')

@component('admin.components.breadcrumbs')
	@slot('title') Создание фильма @endslot
	@slot('parent') Главная @endslot
	@slot('active') Фильмы @endslot
@endcomponent

<form action="{{route('admin.movie.store')}}" method="post" enctype="multipart/form-data">
	{{ csrf_field() }}
	
	@include('admin.movie.particles.form')
	<input type="hidden" name="created_by" value="{{Auth::id()}}"/>
</form>



@endsection
