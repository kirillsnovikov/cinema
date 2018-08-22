@extends('admin.layouts.admin')

@section('content')

@component('admin.components.breadcrumbs')
@slot('title') Парсер teestore @endslot
@slot('parent') Главная @endslot
@slot('parser') Парсер @endslot
@slot('teestore') teestore @endslot
@slot('active') Ссылки @endslot
@endcomponent

<form action="{{route('admin.parser.start')}}" method="post" enctype="multipart/form-data">
	{{ csrf_field() }}
	
	@include('admin.parser.teestore.link.form')
	<input type="hidden" name="created_by" value="{{Auth::id()}}"/>
</form>

@endsection
