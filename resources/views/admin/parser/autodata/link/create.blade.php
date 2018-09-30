@extends('admin.layouts.admin')

@section('content')

@component('admin.components.breadcrumbs')
@slot('title') Парсер AutoData @endslot
@slot('parent') Главная @endslot
@slot('parser') Парсер @endslot
@slot('autodata') AutoData @endslot
@slot('active') Ссылки @endslot
@endcomponent

<form action="{{route('admin.parser.autodata.link')}}" method="post" enctype="multipart/form-data">
	{{ csrf_field() }}
	
	@include('admin.parser.autodata.link.form')
	<input type="hidden" name="created_by" value="{{Auth::id()}}"/>
        <input type="hidden" name="type_parser" value="AutodataLink"/>
</form>

@endsection
