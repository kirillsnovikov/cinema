@foreach ($countries as $country)

	<option value="{{$country->id or ''}}"
	
		@isset($movie->id)
			@foreach ($movie->countries as $country_movie)
				@if($country->id == $country_movie->id)
					selected=""
				@endif
			@endforeach
		@endisset
		>
		
		{!! $delimiter or '' !!}{{$country->title or ''}}
	</option>

@endforeach
