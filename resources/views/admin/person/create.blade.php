@extends('admin.layouts.admin')

@section('content')

@component('admin.components.breadcrumbs')
@slot('title') Создание персоны @endslot
@slot('parent') Главная @endslot
@slot('active') Персоны @endslot
@endcomponent

<form action="{{route('admin.person.store')}}" method="post" enctype="multipart/form-data">
    {{ csrf_field() }}

    @include('admin.person.particles.form')
    <input type="hidden" name="created_by" value="{{Auth::id()}}"/>
</form>



@endsection
