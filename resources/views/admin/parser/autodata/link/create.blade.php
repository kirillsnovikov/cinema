@extends('admin.layouts.admin')

@section('content')

@component('admin.components.breadcrumbs')
@slot('title') Парсер AutoData @endslot
@slot('parent') Главная @endslot
@slot('parser') Парсер @endslot
@slot('autodata') AutoData @endslot
@slot('active') Ссылки @endslot
@endcomponent



<form class="my-2" action="{{route('admin.parser.autodata.link')}}" method="post" enctype="multipart/form-data">
    {{ csrf_field() }}

    @if(isset($output))
    <div class="alert alert-danger" role="alert">
        {{$output}}
    </div>
    @endif


    @include('admin.parser.autodata.link.loginform')

    <input type="hidden" name="type_parser" value="AutodataLogin"/>
</form>
<form class="my-2" action="{{route('admin.parser.autodata.link')}}" method="post" enctype="multipart/form-data">
    {{ csrf_field() }}


    @include('admin.parser.autodata.link.logoutform')

    <input type="hidden" name="type_parser" value="AutodataLogout"/>
</form>
<form class="my-2" action="{{route('admin.parser.autodata.link')}}" method="post" enctype="multipart/form-data">
    {{ csrf_field() }}

    @include('admin.parser.autodata.link.form')

    <input type="hidden" name="type_parser" value="AutodataLink"/>
</form>

@endsection
