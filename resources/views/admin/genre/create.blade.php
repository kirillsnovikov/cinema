@extends('admin.layouts.admin')

@section('content')

@component('admin.components.breadcrumbs')
	@slot('title') Создание жанра @endslot
	@slot('parent') Главная @endslot
	@slot('active') Жанры @endslot
@endcomponent

<form action="{{route('admin.genre.store')}}" method="post">
	{{ csrf_field() }}
	
	@include('admin.genre.particles.form')
	<input type="hidden" name="created_by" value="{{Auth::id()}}"/>
</form>



@endsection
