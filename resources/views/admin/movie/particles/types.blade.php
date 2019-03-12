@foreach ($types as $type)

    <option value="{{$type->id or ''}}"
        @isset($movie->id)
            @foreach ($movie->types as $movie_type)
                @if($type->id == $movie_type->id)
                    selected
                @endif
            @endforeach
        @endisset
    >
        {{$type->title or ''}}
    </option>

@endforeach
