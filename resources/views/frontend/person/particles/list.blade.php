<ul class="unstyled filmography">
    @forelse($movies as $movie)
    <li>
        <time class="time">2010</time>
        <a href="{{route('video', $movie->slug)}}" class="title">{{$movie->title}}</a>
        <div class="kp_raiting">КиноПоиск: {{$movie->kp_raiting / 10000}}</div>
        <div class="imdb_raiting">IMDb: {{$movie->imdb_raiting / 10000}}</div>
    </li>
    @empty
    <li>Нет фильмов</li>
    @endforelse
</ul>