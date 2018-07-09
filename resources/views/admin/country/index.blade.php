@extends('admin.layouts.admin')

@section('content')

@component('admin.components.breadcrumbs')
@slot('title') Список стран @endslot
@slot('parent') Главная @endslot
@slot('active') Страны @endslot
@endcomponent

<div class="text-right mb-3">
    <a href="{{route('admin.country.create')}}"><i class="fa fa-plus-circle fa-3x"></i></a>
</div>

<table class="table table-striped">
    <thead>
        <tr>
            <th scope="col">#id</th>
            <th scope="col">Title</th>
            <th scope="col">Slug</th>
            <th scope="col">Published</th>
            <th scope="col">Created_at</th>
            <th scope="col"></th>
        </tr>
    </thead>
    <tbody>
        @forelse($countries as $country)
        <tr>
            <th scope="row">{{ $country->id }}</th>
            <td><a href="{{route('admin.country.edit', $country)}}">{{ $country->title }}</a></td>
            <td>{{ str_limit($country->slug, 10) }}</td>
            <td>{{ $country->published }}</td>
            <td>{{ $country->created_at }}</td>
            <td>


                <form onsubmit="if (confirm('Удалить?')) {
                            return true
                        } else {
                            return false
                        }" action="{{route('admin.country.destroy', $country)}}" method="post">
                    <input type="hidden" name="_method" value="delete"/>
                    {{ csrf_field() }}

                    <a href="{{route('admin.country.edit', $country)}}" class="btn btn-link p-0"><i class="fa fa-edit fa-lg text-success"></i></a>
                    <button type="submit" class="btn btn-link p-0"><i class="fa fa-trash-alt fa-lg text-danger"></i></button>
                </form>


            </td>
        </tr>
        @empty
    <div class="alert alert-danger" role="alert">
        Нет стран!
    </div>
    @endforelse
</tbody>
</table>

<ul class="pagination float-right">
    {{$countries->links()}}
</ul>

@endsection
