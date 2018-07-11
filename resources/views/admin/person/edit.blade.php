@extends('admin.layouts.admin')

@section('content')

@component('admin.components.breadcrumbs')
@slot('title') Редактирование персоны @endslot
@slot('parent') Главная @endslot
@slot('active') Персоны @endslot
@endcomponent

<form action="{{route('admin.person.update', $person)}}" method="post" enctype="multipart/form-data">
    <input type="hidden" name="_method" value="put"/>
    {{ csrf_field() }}

    @include('admin.person.particles.form')
    <input type="hidden" name="modified_by" value="{{Auth::id()}}"/>
</form>

@endsection
