<section class="filmography-block">
    <div class="filmography">
        <h2>Фильмография</h2>
        @if(count($director_movie))
            <h3 id="rezhisser">Режиссер</h3>
            @include('frontend.person.particles.list', ['movies' => $director_movie])
        @endif
        @if(count($actor_movie))
            <h3 id="akter">Актер</h3>
            @include('frontend.person.particles.list', ['movies' => $actor_movie])
        @endif
    </div>
</section>