<section class="info-block">
    <table>
        <tbody>
            <tr>
                <th>Год</th>
                <td>
                    <time datetime="{{$movie->premiere}}">{{date('Y', strtotime($movie->premiere))}}</time>
                </td>
            </tr>
            @if(count($movie->countries))
            <tr>
                <th>Страна</th>
                <td>
                    @foreach($movie->countries as $country)
                    <a href="{{route('country', $country->slug)}}">{{(!$loop->last) ? $country->title . ',' : $country->title}}</a>
                    @endforeach
                </td>
            </tr>
            @endif
            @if(count($movie->directors))
            <tr>
                <th>Режиссер</th>
                <td>
                    @foreach($movie->directors as $director)
                    <a href="{{route('person', $director->slug)}}">
                        {{(!$loop->last) ? $director->name . ', ' : $director->name}}
                    </a>
                    @endforeach
                </td>
            </tr>
            @endif
            @if(count($movie->actors))
            <tr>
                <th>Актеры</th>
                <td>
                    @foreach($movie->actors as $actor)
                    <a href="{{route('person', $actor->slug)}}">{{(!$loop->last) ? $actor->name . ',' : $actor->name}}</a>
                    @endforeach
                </td>
            </tr>
            @endif
            @if(count($movie->genres))
            <tr>
                <th>Жанр</th>
                <td>
                    @foreach($movie->genres as $genre)
                    <a href="{{route('genre', [$movie->type->slug, $genre->slug])}}">{{(!$loop->last) ? ucfirst($genre->title) . ',' : ucfirst($genre->title)}}</a>
                    @endforeach
                </td>
            </tr>
            @endif
            @if(isset($movie->duration))
            <tr>
                <th>Время</th>
                <td>{{date('G\чi', mktime(0,$movie->duration)) . ' (' . $movie->duration . ' мин.)'}}</td>
            </tr>
            @endif
        </tbody>
    </table>
</section>