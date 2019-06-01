<aside>
    <div class="sidebar">
        <div class="title">Жанры</div>
        <ul class="unstyled">
            @forelse($genres as $genre)
            <li>
                <a href="{{route('genre', ['type_slug' => $type->slug, 'genre_slug' => $genre->slug])}}">
                    {{$genre->title}}|{{count($genre->movies)}}
                </a>
            </li>
            @empty
            <li>Нет жанров</li>
            @endforelse
        </ul>
    </div>
</aside>