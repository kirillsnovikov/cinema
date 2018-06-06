@extends('admin.layouts.admin')

@section('content')

<div class="card-deck mt-3 text-white">
	<div class="card bg-success">
		<!-- <img class="card-img-top" src="..." alt="Card image cap"> -->
		<div class="card-body">
			<h5 class="card-title">Категории
				<span class="badge badge-light">{{$count_categories}}</span>
			</h5>
			<p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional content.</p>
			<a href="{{ route('admin.category.index') }}" class="btn btn-outline-light">GoToEdit</a>
			<p>sdfsd</p>
		</div>
		@foreach($categories as $category)
			<div class="card-footer">
				<a href="{{route('admin.category.edit', $category)}}" class="text-white text-uppercase">
					{{$category->title}}
					<span class="d-inline badge badge-light">{{$category->articles()->count()}}</span>
				</a>
			</div>
		@endforeach
	</div>
	<div class="card bg-danger">
		<!-- <img class="card-img-top" src="..." alt="Card image cap"> -->
		<div class="card-body">
			<h5 class="card-title">Материалы
				<span class="badge badge-light">{{$count_articles}}</span>
			</h5>
			<p class="card-text">This card has supporting text below as a natural lead-in to additional content.</p>
			<a href="{{ route('admin.article.index') }}" class="btn btn-outline-light">GoToEdit</a>
		</div>
		@foreach($articles as $article)
			<div class="card-footer">
				<a href="{{route('admin.article.edit', $article)}}" class="d-block text-white text-uppercase">
					{{$article->title}}
					<em><small class="d-block text-capitalize">{{$article->categories()->pluck('title')->implode(', ')}}</small></em>
				</a>
			</div>
		@endforeach
	</div>
</div>
<div class="card-deck mt-3 text-white">
	<div class="card bg-warning">
		<!-- <img class="card-img-top" src="..." alt="Card image cap"> -->
		<div class="card-body">
			<h5 class="card-title">Комментарии</h5>
			<p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional content.</p>
			<button type="button" class="btn btn-outline-light">GoToEdit</button>
		</div>
		<div class="card-footer">
			<small>Last updated 3 mins ago</small>
		</div>
	</div>
	<div class="card bg-info">
		<!-- <img class="card-img-top" src="..." alt="Card image cap"> -->
		<div class="card-body">
			<h5 class="card-title">Пользователи</h5>
			<p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional content.</p>
			<button type="button" class="btn btn-outline-light">GoToEdit</button>
		</div>
		<div class="card-footer">
			<small>Last updated 3 mins ago</small>
		</div>
	</div>
</div>

@endsection