@foreach ($genres as $genre_list)

	<option value="{{$genre_list->id or ''}}"
	
		@isset($genre->id)
			@if($genre->parent_id == $genre_list->id)
				selected=""
			@endif
			
			@if($genre->parent_id == $genre_list->id)
				hidden=""
			@endif
		@endisset
		>
		
		{!! $delimiter or '' !!}{{$genre_list->title or ''}}
	</option>
	
	@if(count($genre_list->children) > 0)
	
		@include('admin.genre.particles.list', [
			'genres' => $genre_list->children,
			'delimiter'  => ' - ' . $delimiter
		])
	
	@endif

@endforeach
