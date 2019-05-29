<section class="content-block">
    <div class="content">
        <div class="poster">
            <img src="https://loremflickr.com/300/400/art/?random={{$movie->image}}"
                 class="img-fluid" alt="Постер к фильму {{$movie->title}}"
                 title="Постер к фильму {{$movie->title}}" />
        </div>
        <div class="properties">
            @include('frontend.movie.particles.info')
            @include('frontend.movie.particles.raiting')
            @include('frontend.movie.particles.description')
            @include('frontend.movie.particles.player')
        </div>
    </div>
</section>