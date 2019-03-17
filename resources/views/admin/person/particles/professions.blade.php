@foreach ($professions as $profession)

    <option value="{{$profession->id or ''}}"
        @isset($person->id)
            @foreach ($person->professions as $profession_person)
                @if($profession->id == $profession_person->id)
                    selected=""
                @endif
            @endforeach
        @endisset
        >
        {{$profession->title or ''}}
    </option>

@endforeach
