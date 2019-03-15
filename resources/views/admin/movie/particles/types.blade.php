@foreach ($types as $type)

    <option value="{{$type->id or ''}}"
        @isset($movie->id)
            @if($type->id == $movie->type_id)
                selected
            @endif
        @endisset
    >
        {{$type->title or ''}}
    </option>

@endforeach
