@foreach($categories as $category)
	@if($category->children->where('published', 1)->count())
		<li class="dropdown">
			<a class="dropdown-toggle nav-link" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false" href="{{url("blog/category/$category->slug")}}">
				{{$category->title}} <span class="caret"></span>
			</a>
			<ul class="dropdown-menu">
				@include('layouts.list', ['categories' => $category->children])
			</ul>
	@else
		<li>
			<a class="nav-link" href="{{url("blog/category/$category->slug")}}">{{$category->title}}</a>
	@endif
		</li>
@endforeach