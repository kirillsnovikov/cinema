@extends('admin.layouts.admin')

@section('content')

@component('admin.components.breadcrumbs')
@slot('title') Список типов @endslot
@slot('parent') Главная @endslot
@slot('active') Типы @endslot
@endcomponent

<div class="text-right mb-3">
    <a href="{{route('admin.type.create')}}"><i class="fa fa-plus-circle fa-3x"></i></a>
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
        @forelse($types as $type)
        <tr>
            <th scope="row">{{ $type->id }}</th>
            <td><a href="{{route('admin.type.edit', $type)}}">{{ $type->title }}</a></td>
            <td>{{ str_limit($type->slug, 10) }}</td>
            <td>{{ $type->published }}</td>
            <td>{{ $type->created_at }}</td>
            <td>


                <form onsubmit="if (confirm('Удалить?')) {
                            return true
                        } else {
                            return false
                        }" action="{{route('admin.type.destroy', $type)}}" method="post">
                    <input type="hidden" name="_method" value="delete"/>
                    {{ csrf_field() }}

                    <a href="{{route('admin.type.edit', $type)}}" class="btn btn-link p-0"><i class="fa fa-edit fa-lg text-success"></i></a>
                    <button type="submit" class="btn btn-link p-0"><i class="fa fa-trash-alt fa-lg text-danger"></i></button>
                </form>


            </td>
        </tr>
        @empty
    <div class="alert alert-danger" role="alert">
        Нет жанров!
    </div>
    @endforelse
</tbody>
</table>

<ul class="pagination float-right">
    {{$types->links()}}
</ul>

@endsection
