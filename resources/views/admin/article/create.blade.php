@extends('admin.layouts.admin')

@section('content')

@component('admin.components.breadcrumbs')
	@slot('title') Создание статьи @endslot
	@slot('parent') Главная @endslot
	@slot('active') Статьи @endslot
@endcomponent

<form action="{{route('admin.article.store')}}" method="post" enctype="multipart/form-data">
	{{ csrf_field() }}
	
	@include('admin.article.particles.form')
	<input type="hidden" name="created_by" value="{{Auth::id()}}"/>
</form>



@endsection
