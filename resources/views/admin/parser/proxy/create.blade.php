@extends('admin.layouts.admin')

@section('content')

@component('admin.components.breadcrumbs')
@slot('title') Чекер Прокси @endslot
@slot('parent') Главная @endslot
@slot('parser') Парсер @endslot
@slot('active') CheckProxy @endslot
@endcomponent

<form action="{{route('admin.parser.check')}}" method="post" enctype="multipart/form-data">
	{{ csrf_field() }}
	
	@include('admin.parser.proxy.form')
	<input type="hidden" name="created_by" value="{{Auth::id()}}"/>
</form>

@endsection
