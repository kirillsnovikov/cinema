@extends('admin.layouts.admin')

@section('content')

@component('admin.components.breadcrumbs')
@slot('title') Список профессий @endslot
@slot('parent') Главная @endslot
@slot('active') Профессии @endslot
@endcomponent

<div class="text-right mb-3">
    <a href="{{route('admin.profession.create')}}"><i class="fa fa-plus-circle fa-3x"></i></a>
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
        @forelse($professions as $profession)
        <tr>
            <th scope="row">{{ $profession->id }}</th>
            <td><a href="{{route('admin.profession.edit', $profession)}}">{{ $profession->title }}</a></td>
            <td>{{ str_limit($profession->slug, 10) }}</td>
            <td>{{ $profession->published }}</td>
            <td>{{ $profession->created_at }}</td>
            <td>


                <form onsubmit="if (confirm('Удалить?')) {
                            return true
                        } else {
                            return false
                        }" action="{{route('admin.profession.destroy', $profession)}}" method="post">
                    <input type="hidden" name="_method" value="delete"/>
                    {{ csrf_field() }}

                    <a href="{{route('admin.profession.edit', $profession)}}" class="btn btn-link p-0"><i class="fa fa-edit fa-lg text-success"></i></a>
                    <button type="submit" class="btn btn-link p-0"><i class="fa fa-trash-alt fa-lg text-danger"></i></button>
                </form>


            </td>
        </tr>
        @empty
    <div class="alert alert-danger" role="alert">
        Нет профессий!
    </div>
    @endforelse
</tbody>
</table>

<ul class="pagination float-right">
    {{$professions->links()}}
</ul>

@endsection
