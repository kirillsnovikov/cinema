@foreach ($types as $type)

    <option value="{{$type->id or ''}}"
        @if (count($genre->types) > 0)
            @foreach ($genre->types as $genre_type)
                @if ($type->id == $genre_type->id)
                    selected
                @endif
            @endforeach
        @endif
    >
        {{$type->title or ''}}
    </option>


@endforeach
