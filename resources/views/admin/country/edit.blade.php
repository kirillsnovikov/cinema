@extends('admin.layouts.admin')

@section('content')

@component('admin.components.breadcrumbs')
	@slot('title') Редактирование страны @endslot
	@slot('parent') Главная @endslot
	@slot('active') Страны @endslot
@endcomponent

<form action="{{route('admin.country.update', $country)}}" method="post">
	<input type="hidden" name="_method" value="put"/>
	{{ csrf_field() }}
	
	@include('admin.country.particles.form')
	<input type="hidden" name="modified_by" value="{{Auth::id()}}"/>
</form>



@endsection
