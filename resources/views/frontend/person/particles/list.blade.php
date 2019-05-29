@forelse($movies as $movie)
{{$movie->title}}
@empty
@endforelse