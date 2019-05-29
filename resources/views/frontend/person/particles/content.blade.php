<section class="content-block">
    <div class="content">
        <div class="poster">
            <img src="https://loremflickr.com/300/400/face/?random={{$person->image}}"
                 class="img-fluid"
                 alt="Фото {{$fullname}}"
                 title="Фото {{$fullname}}"/>
        </div>
        <div class="properties">
            @include('frontend.person.particles.info')
            @include('frontend.person.particles.description')
            @include('frontend.person.particles.filmography')
        </div>
    </div>
</section>