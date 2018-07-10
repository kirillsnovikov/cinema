@foreach ($professions as $profession)

	<option value="{{$profession->id or ''}}"
	
		@isset($movie->id)
			@foreach ($movie->professions as $profession_movie)
				@if($profession->id == $profession_movie->id)
					selected=""
				@endif
			@endforeach
		@endisset
		>
		
		{!! $delimiter or '' !!}{{$profession->title or ''}}
	</option>

@endforeach
