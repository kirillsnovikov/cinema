@extends('admin.layouts.admin')

@section('content')

@component('admin.components.breadcrumbs')
	@slot('title') Редактирование категории @endslot
	@slot('parent') Главная @endslot
	@slot('active') Категории @endslot
@endcomponent

<form action="{{route('admin.category.update', $category)}}" method="post">
	<input type="hidden" name="_method" value="put"/>
	{{ csrf_field() }}
	
	@include('admin.category.particles.form')
	<input type="hidden" name="modified_by" value="{{Auth::id()}}"/>
</form>



@endsection
