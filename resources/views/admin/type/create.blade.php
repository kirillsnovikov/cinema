@extends('admin.layouts.admin')

@section('content')

@component('admin.components.breadcrumbs')
	@slot('title') Создание Типа @endslot
	@slot('parent') Главная @endslot
	@slot('active') Типы @endslot
@endcomponent

<form action="{{route('admin.type.store')}}" method="post">
	{{ csrf_field() }}
	
	@include('admin.type.particles.form')
	<input type="hidden" name="created_by" value="{{Auth::id()}}"/>
</form>



@endsection
