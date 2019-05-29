<div class="card">
    <a href="{{route('video', $movie->slug)}}">
        <div class="card-poster">
            <img src="https://loremflickr.com/300/400/art/?random={{$movie->image}}"
                 alt="Постер к фильму '{{$movie->title}}'"
                 title="Постер к фильму '{{$movie->title}}'"/>
        </div>
        <div class="card-title">
            {{$movie->title}}
        </div>
    </a>
    <div class="card-raiting">{{$movie->kp_raiting / 10000}}</div>
</div>