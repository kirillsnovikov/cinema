@extends('admin.layouts.admin')

@section('content')

@component('admin.components.breadcrumbs')
@slot('title') Редактирование фильма @endslot
@slot('parent') Главная @endslot
@slot('active') Фильмы @endslot
@endcomponent

@forelse($errors as $error)
<div class="alert alert-danger" role="alert">
    <ul class="m-0">
        <li>{{$error}}</li>
    </ul>
</div>
@empty
@endforelse

<form action="{{route('admin.movie.update', $movie)}}" method="post" enctype="multipart/form-data">
    <input type="hidden" name="_method" value="put"/>
    {{ csrf_field() }}

    @include('admin.movie.particles.form')
    <input type="hidden" name="modified_by" value="{{Auth::id()}}"/>
</form>

@endsection
