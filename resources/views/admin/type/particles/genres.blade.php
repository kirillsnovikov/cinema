@foreach ($genres as $genre)

    <option value="{{$genre->id or ''}}"
        @isset($type->id)
            @foreach ($type->genres as $genre_type)
                @if ($genre->id == $genre_type->id)
                    selected
                @endif
            @endforeach
        @endisset
    >
        {{$genre->title or ''}}
    </option>


@endforeach
