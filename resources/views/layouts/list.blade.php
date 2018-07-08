@foreach($genres as $genre)
@if($genre->children->where('published', 1)->count())
<li class="dropdown">
    <a class="dropdown-toggle nav-link" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false" href="{{url("blog/genre/$genre->slug")}}">
        {{$genre->title}} <span class="caret"></span>
    </a>
    <ul class="dropdown-menu">
        @include('layouts.list', ['genres' => $genre->children])
    </ul>
    @else
<li>
    <a class="nav-link" href="{{url("blog/genre/$genre->slug")}}">{{$genre->title}}</a>
    @endif
</li>
@endforeach