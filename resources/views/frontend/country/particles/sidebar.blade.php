<aside>
    <div class="sidebar">
        <div class="title">Страны</div>
        <ul class="unstyled">
            @forelse($countries as $country)
            <li class="{{$country_slug == $country->slug ? 'active' : ''}}">
                <a href="{{route('country', $country->slug)}}">
                    {{$country->title.' ('.$country->movies->count().')'}}
                    <img class="ml-3"src="https://www.countryflags.io/{{$country->code_alpha2}}/flat/32.png">
                </a>
            </li>
            @empty
            <li>Нет стран</li>
            @endforelse
        </ul>
    </div>
</aside>