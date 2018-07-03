@extends('admin.layouts.admin')

@section('content')

@component('admin.components.breadcrumbs')
	@slot('title') Редактирование статьи @endslot
	@slot('parent') Главная @endslot
	@slot('active') Статьи @endslot
@endcomponent

<form action="{{route('admin.article.update', $article)}}" method="post" enctype="multipart/form-data">
	<input type="hidden" name="_method" value="put"/>
	{{ csrf_field() }}
	
	@include('admin.article.particles.form')
	<input type="hidden" name="modified_by" value="{{Auth::id()}}"/>
</form>



@endsection
