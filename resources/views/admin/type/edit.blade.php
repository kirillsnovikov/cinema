@extends('admin.layouts.admin')

@section('content')

@component('admin.components.breadcrumbs')
	@slot('title') Редактирование Типа @endslot
	@slot('parent') Главная @endslot
	@slot('active') Типы @endslot
@endcomponent

<form action="{{route('admin.type.update', $type)}}" method="post">
	<input type="hidden" name="_method" value="put"/>
	{{ csrf_field() }}
	
	@include('admin.type.particles.form')
	<input type="hidden" name="modified_by" value="{{Auth::id()}}"/>
</form>



@endsection
