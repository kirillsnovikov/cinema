@foreach ($professions as $profession)

	<option value="{{$profession->id or ''}}"
	
		@isset($person->id)
			@foreach ($person->professions as $profession_movie)
				@if($profession->id == $profession_movie->id)
					selected=""
				@endif
			@endforeach
		@endisset
		>
		
		{!! $delimiter or '' !!}{{$profession->title or ''}}
	</option>

@endforeach
