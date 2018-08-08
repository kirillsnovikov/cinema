@extends('admin.layouts.admin')

@section('content')
@component('admin.components.breadcrumbs')
@slot('title') Парсер @endslot
@slot('parent') Главная @endslot
@slot('active') Парсер @endslot
@endcomponent
<a href="{{route('admin.parser.create')}}" class="btn btn-outline-success btn-lg">Запустить новый парсинг</a>
@endsection
