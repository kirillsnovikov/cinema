<section class="content-block">
    <div class="content">
        @forelse($movies as $movie)
        @include('frontend.components.card')
        @empty
        <div>Нет опубликованых фильмов!</div>
        @endforelse
    </div>
    <div class="pagination">{{$movies->links('frontend.components.paginate')}}</div>
</section>