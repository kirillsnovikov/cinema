@extends('admin.layouts.admin')

@section('content')
@component('admin.components.breadcrumbs')
@slot('title') Парсер Автодата @endslot
@slot('parent') Главная @endslot
@slot('parser') Парсер @endslot
@slot('active') Автодата @endslot
@endcomponent
<a href="{{route('admin.parser.autodata.link.create')}}" class="btn btn-outline-success btn-lg">Парсинг ссылок</a>
<a href="{{route('admin.parser.autodata.card.create')}}" class="btn btn-outline-success btn-lg">Парсинг карточек</a>
@endsection