@extends('admin.layouts.admin')

@section('content')

@component('admin.components.breadcrumbs')
@slot('title') Список фильмов @endslot
@slot('parent') Главная @endslot
@slot('active') Фильмы @endslot
@endcomponent

<div class="text-right mb-3">
    <a href="{{route('admin.movie.create')}}"><i class="fa fa-plus-circle fa-3x"></i></a>
</div>

<table class="table table-striped">
    <thead>
        <tr>
            <th scope="col">#id</th>
            <th scope="col">Title</th>
            <th scope="col">Slug</th>
            <th scope="col">Created_by</th>
            <th scope="col">Modified_by</th>
            <th scope="col">Created_at</th>
            <th scope="col"></th>
        </tr>
    </thead>
    <tbody>
        @forelse($movies as $movie)
        <tr>
            <th scope="row">{{ $movie->id }}</th>
            <td>{{ str_limit($movie->title, 30) }}</td>
            <td>{{ str_limit($movie->slug, 10) }}</td>
            <td>{{ $movie->userCreated()->pluck('name')->implode(', ') }}</td>
            <td>@if($modified_by)
                {{ $movie->userModified()->pluck('name')->implode(', ') }}</td>
            @else Не отредактировано
            @endif
            <td>{{ $movie->created_at }}</td>
            <td>


                <form onsubmit="if (confirm('Удалить?')) {
                            return true
                        } else {
                            return false
                        }" action="{{route('admin.movie.destroy', $movie)}}" method="post">
                    <input type="hidden" name="_method" value="delete"/>
                    {{ csrf_field() }}

                    <a href="{{route('admin.movie.edit', $movie)}}" class="btn btn-link p-0"><i class="fa fa-edit fa-lg text-success"></i></a>
                    <button type="submit" class="btn btn-link p-0"><i class="fa fa-trash-alt fa-lg text-danger"></i></button>
                </form>


            </td>
        </tr>
        @empty
        <div class="alert alert-danger" role="alert">Нет фильмов!</div>
        @endforelse
    </tbody>
</table>

<ul class="pagination float-right">
    {{$movies->links()}}
</ul>

@endsection
