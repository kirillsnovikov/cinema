<section class="filmography-block">
    <div class="filmography">
        <h2>Фильмография</h2>
        @include('frontend.person.particles.list', ['movies' => $director_movie, 'type' => 'Режиссер'])
        @include('frontend.person.particles.list', ['movies' => $actor_movie, 'type' => 'Актер'])
    </div>
</section>