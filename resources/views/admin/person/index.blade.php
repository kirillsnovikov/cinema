@extends('admin.layouts.admin')

@section('content')

@component('admin.components.breadcrumbs')
@slot('title') Список персон @endslot
@slot('parent') Главная @endslot
@slot('active') Персоны @endslot
@endcomponent

<div class="text-right mb-3">
    <a href="{{route('admin.person.create')}}"><i class="fa fa-plus-circle fa-3x"></i></a>
</div>

<table class="table table-striped">
    <thead>
        <tr>
            <th scope="col">#id</th>
            <th scope="col">Name</th>
            <th scope="col">Slug</th>
            <th scope="col">Created_by</th>
            <th scope="col">Modified_by</th>
            <th scope="col">Created_at</th>
            <th scope="col"></th>
        </tr>
    </thead>
    <tbody>
        @forelse($persons as $person)
        <tr>
            <th scope="row">{{ $person->id }}</th>
            <td>{{ str_limit($person->firstname.' '.$person->lastname, 30) }}</td>
            <td>{{ str_limit($person->slug, 10) }}</td>
            <td>{{ $person->userCreated()->pluck('name')->implode(', ') }}</td>
            <td>@if($modified_by)
                {{ $person->userModified()->pluck('name')->implode(', ') }}</td>
            @else Не отредактировано
            @endif
            <td>{{ $person->created_at }}</td>
            <td>


                <form onsubmit="if (confirm('Удалить?')) {
                            return true
                        } else {
                            return false
                        }" action="{{route('admin.person.destroy', $person)}}" method="post">
                    <input type="hidden" name="_method" value="delete"/>
                    {{ csrf_field() }}

                    <a href="{{route('admin.person.edit', $person)}}" class="btn btn-link p-0"><i class="fa fa-edit fa-lg text-success"></i></a>
                    <button type="submit" class="btn btn-link p-0"><i class="fa fa-trash-alt fa-lg text-danger"></i></button>
                </form>


            </td>
        </tr>
        @empty
    <div class="alert alert-danger" role="alert">
        Нет персон!
    </div>
    @endforelse
</tbody>
</table>

<ul class="pagination float-right">
    {{$persons->links()}}
</ul>

@endsection
