@if(count($movies))
<h3>{{$type}}</h3>
<ul class="unstyled filmography">
    @forelse($movies as $movie)
    <li>
        <time></time>
        <a href="" class="title">{{$movie->title}}</a>
        <div>Кинопоиск: {{$movie->kp_raiting / 10000}}</div>
        <div>IMDb: {{$movie->imdb_raiting / 10000}}</div>
    </li>
    @empty
    <li>Нет фильмов</li>
    @endforelse
</ul>
@endif