@extends('layouts.app')

@section('title', $category->title . ' - CCO.CC')

@section('content')

	<div class="container">
		<p class="h4 text-capitalize">{{$category->title}}</p>
		<div class="row">
		@forelse($articles as $article)
			<div class="col-2 mb-4">
				<div class="card">
					<img src="{{$article->image}}" class="card-img-top" alt="{{$article->title}}"/>
					<div class="card-body">
						<p class="card-title h5">{{$article->title}}</p>
						<p class="card-text">{!!$article->description_short!!}</p>
						<a href="{{route('article', $article->slug)}}" class="btn btn-primary">Читать далее...</a>
					</div>
				</div>
			</div>
		@empty
			<div class="col-12">
				<div class="alert alert-danger" role="alert">
					Нет опубликованых материалов!
				</div>
			</div>
		@endforelse
		</div>
		<ul class="pagination float-right">
			{{$articles->links()}}
		</ul>
	</div>
@endsection
