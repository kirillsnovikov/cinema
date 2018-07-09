@extends('admin.layouts.admin')

@section('content')

@component('admin.components.breadcrumbs')
	@slot('title') Создание страны @endslot
	@slot('parent') Главная @endslot
	@slot('active') Страны @endslot
@endcomponent

<form action="{{route('admin.country.store')}}" method="post">
	{{ csrf_field() }}
	
	@include('admin.country.particles.form')
	<input type="hidden" name="created_by" value="{{Auth::id()}}"/>
</form>



@endsection
