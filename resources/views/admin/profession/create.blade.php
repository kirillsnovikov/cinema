@extends('admin.layouts.admin')

@section('content')

@component('admin.components.breadcrumbs')
@slot('title') Создание профессии @endslot
@slot('parent') Главная @endslot
@slot('active') Профессии @endslot
@endcomponent

<form action="{{route('admin.profession.store')}}" method="post">
    {{ csrf_field() }}

    @include('admin.profession.particles.form')
    <input type="hidden" name="created_by" value="{{Auth::id()}}"/>
</form>



@endsection
