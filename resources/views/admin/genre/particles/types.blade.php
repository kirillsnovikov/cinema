@foreach ($types as $type)

    <option value="{{$type->id or ''}}"
        @isset($genre->id)
            @foreach ($genre->types as $type_genre)
                @if ($type->id == $type_genre->id)
                    selected
                @endif
            @endforeach
        @endisset
    >
        {{$type->title or ''}}
    </option>


@endforeach
