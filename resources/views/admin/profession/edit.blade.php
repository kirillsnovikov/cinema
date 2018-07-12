@extends('admin.layouts.admin')

@section('content')

@component('admin.components.breadcrumbs')
@slot('title') Редактирование профессии @endslot
@slot('parent') Главная @endslot
@slot('active') Профессии @endslot
@endcomponent

<form action="{{route('admin.profession.update', $profession)}}" method="post">
    <input type="hidden" name="_method" value="put"/>
    {{ csrf_field() }}

    @include('admin.profession.particles.form')
    <input type="hidden" name="modified_by" value="{{Auth::id()}}"/>
</form>



@endsection
