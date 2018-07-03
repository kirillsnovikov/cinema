@extends('admin.layouts.admin')

@section('content')

@component('admin.components.breadcrumbs')
@slot('title') Список жанров @endslot
@slot('parent') Главная @endslot
@slot('active') Жанры @endslot
@endcomponent

<div class="text-right mb-3">
    <a href="{{route('admin.genre.create')}}"><i class="fa fa-plus-circle fa-3x"></i></a>
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
        @forelse($genres as $genre)
        <tr>
            <th scope="row">{{ $genre->id }}</th>
            <td><a href="{{route('admin.genre.edit', $genre)}}">{{ $genre->title }}</a></td>
            <td>{{ str_limit($genre->slug, 10) }}</td>
            <td>{{ $genre->published }}</td>
            <td>{{ $genre->created_at }}</td>
            <td>


                <form onsubmit="if (confirm('Удалить?')) {
                            return true
                        } else {
                            return false
                        }" action="{{route('admin.genre.destroy', $genre)}}" method="post">
                    <input type="hidden" name="_method" value="delete"/>
                    {{ csrf_field() }}

                    <a href="{{route('admin.genre.edit', $genre)}}" class="btn btn-link p-0"><i class="fa fa-edit fa-lg text-success"></i></a>
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
    {{$genres->links()}}
</ul>

@endsection
