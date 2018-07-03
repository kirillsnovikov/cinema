@extends('admin.layouts.admin')

@section('content')

@component('admin.components.breadcrumbs')
	@slot('title') Редактирование жанра @endslot
	@slot('parent') Главная @endslot
	@slot('active') Жанры @endslot
@endcomponent

<form action="{{route('admin.genre.update', $genre)}}" method="post">
	<input type="hidden" name="_method" value="put"/>
	{{ csrf_field() }}
	
	@include('admin.genre.particles.form')
	<input type="hidden" name="modified_by" value="{{Auth::id()}}"/>
</form>



@endsection
