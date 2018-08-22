@extends('admin.layouts.admin')

@section('content')
@component('admin.components.breadcrumbs')
@slot('title') Парсер Teestore @endslot
@slot('parent') Главная @endslot
@slot('parser') Парсер @endslot
@slot('active') Teestore @endslot
@endcomponent
<a href="{{route('admin.parser.teestore.link.create')}}" class="btn btn-outline-success btn-lg">Парсинг ссылок</a>
<a href="{{route('admin.parser.teestore.card.create')}}" class="btn btn-outline-success btn-lg">Парсинг товаров</a>
@endsection