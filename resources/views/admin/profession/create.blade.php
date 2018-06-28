@extends('admin.layouts.admin')

@section('content')

@component('admin.components.breadcrumbs')
	@slot('title') Создание категории @endslot
	@slot('parent') Главная @endslot
	@slot('active') Категории @endslot
@endcomponent

<form action="{{route('admin.category.store')}}" method="post">
	{{ csrf_field() }}
	
	@include('admin.category.particles.form')
	<input type="hidden" name="created_by" value="{{Auth::id()}}"/>
</form>



@endsection
