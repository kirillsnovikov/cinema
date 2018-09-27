@extends('admin.layouts.admin')

@section('content')
@component('admin.components.breadcrumbs')
@slot('title') Парсер @endslot
@slot('parent') Главная @endslot
@slot('active') Парсер @endslot
@endcomponent
<a href="{{route('admin.parser.kinopoisk.index')}}" class="btn btn-outline-success btn-lg"><i class="fa fa-film fa-lg mr-2"></i>Парсер Кинопоиск</a>
<a href="{{route('admin.parser.autodata.index')}}" class="btn btn-outline-success btn-lg "><i class="fa fa-car fa-lg mr-2"></i>Парсер AutoData</a>
<a href="{{route('admin.parser.proxy.create')}}" class="btn btn-outline-success btn-lg"><i class="fa fa-file-alt fa-lg mr-2"></i>Check Proxies</a>
@endsection
