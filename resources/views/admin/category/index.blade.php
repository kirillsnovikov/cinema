@extends('admin.layouts.admin')

@section('content')

@component('admin.components.breadcrumbs')
	@slot('title') Список категорий @endslot
	@slot('parent') Главная @endslot
	@slot('active') Категории @endslot
@endcomponent

<div class="text-right mb-3">
	<a href="{{route('admin.category.create')}}"><i class="fa fa-plus-circle fa-3x"></i></a>
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
		@forelse($categories as $category)
		<tr>
			<th scope="row">{{ $category->id }}</th>
			<td>{{ $category->title }}</td>
			<td>{{ str_limit($category->slug, 10) }}</td>
			<td>{{ $category->published }}</td>
			<td>{{ $category->created_at }}</td>
			<td>
				
				
				<form onsubmit="if(confirm('Удалить?')){return true}else{return false}" action="{{route('admin.category.destroy', $category)}}" method="post">
					<input type="hidden" name="_method" value="delete"/>
					{{ csrf_field() }}
					
					<a href="{{route('admin.category.edit', $category)}}" class="btn btn-link p-0"><i class="fa fa-edit fa-lg text-success"></i></a>
					<button type="submit" class="btn btn-link p-0"><i class="fa fa-trash-alt fa-lg text-danger"></i></button>
				</form>
				
				
			</td>
		</tr>
		@empty
		<div class="alert alert-danger" role="alert">
			Нет категорий!
		</div>
		@endforelse
	</tbody>
</table>

<ul class="pagination float-right">
	{{$categories->links()}}
</ul>

@endsection
