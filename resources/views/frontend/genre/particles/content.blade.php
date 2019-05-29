<section class="content-block">
    <div class="content">
        @forelse($movies as $movie)
        @include('frontend.components.card')
        @empty
        <div>Нет опубликованых фильмов!</div>
        @endforelse
    </div>
</section>