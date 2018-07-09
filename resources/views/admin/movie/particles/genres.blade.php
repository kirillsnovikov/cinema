@foreach ($genres as $genre)

	<option value="{{$genre->id or ''}}"
	
		@isset($movie->id)
			@foreach ($movie->genres as $genre_movie)
				@if($genre->id == $genre_movie->id)
					selected=""
				@endif
			@endforeach
		@endisset
		>
		
		{!! $delimiter or '' !!}{{$genre->title or ''}}
	</option>
	
	@if(count($genre->children) > 0)
	
		@include('admin.movie.particles.list', [
			'genres' => $genre->children,
			'delimiter'  => ' - ' . $delimiter
		])
	
	@endif

@endforeach
