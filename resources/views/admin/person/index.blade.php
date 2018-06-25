@extends('admin.layouts.admin')

@section('content')

@component('admin.components.breadcrumbs')
	@slot('title') Список новостей @endslot
	@slot('parent') Главная @endslot
	@slot('active') Новости @endslot
@endcomponent

<div class="text-right mb-3">
	<a href="{{route('admin.article.create')}}"><i class="fa fa-plus-circle fa-3x"></i></a>
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
		@forelse($articles as $article)
		<tr>
			<th scope="row">{{ $article->id }}</th>
			<td>{{ str_limit($article->title, 30) }}</td>
			<td>{{ str_limit($article->slug, 10) }}</td>
			<td>{{ $article->userCreated()->pluck('name')->implode(', ') }}</td>
			<td>@if($article->modified_by)
				{{ $article->userModified()->pluck('name')->implode(', ') }}</td>
				@else Не отредактировано
				@endif
			<td>{{ $article->created_at }}</td>
			<td>
				
				
				<form onsubmit="if(confirm('Удалить?')){return true}else{return false}" action="{{route('admin.article.destroy', $article)}}" method="post">
					<input type="hidden" name="_method" value="delete"/>
					{{ csrf_field() }}
					
					<a href="{{route('admin.article.edit', $article)}}" class="btn btn-link p-0"><i class="fa fa-edit fa-lg text-success"></i></a>
					<button type="submit" class="btn btn-link p-0"><i class="fa fa-trash-alt fa-lg text-danger"></i></button>
				</form>
				
				
			</td>
		</tr>
		@empty
		<div class="alert alert-danger" role="alert">
			Нет новостей!
		</div>
		@endforelse
	</tbody>
</table>

<ul class="pagination float-right">
	{{$articles->links()}}
</ul>

@endsection
