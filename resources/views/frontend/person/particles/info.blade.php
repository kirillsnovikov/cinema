<section class="info-block">
    <table>
        <tbody>
            @if(count($person->professions))
            <tr>
                <th scope="row">Профессии</th>
                <td>
                    @foreach($person->professions as $profession)
                    <a href="#{{$profession->slug}}">{{(!$loop->last) ? $profession->title . ',' : $profession->title}}</a>
                    @endforeach
                </td>
            </tr>
            @endif
            @if(isset($person->tall))
            <tr>
                <th scope="row">Рост</th>
                <td>{{$person->tall / 100}} м</td>
            </tr>
            @endif
            @if(isset($birth_date))
            <tr>
                <th scope="row">Дата рождения</th>
                <td><time datetime="{{$birth_date}}">{{$birth_date}}</time></td>
            </tr>
            @endif
            @if(isset($person->countryBirth))
            <tr>
                <th scope="row">Место рождения</th>
                <td>
                    <a href="{{route('country', $person->countryBirth->slug)}}">{{$person->countryBirth->title}}</a>
                </td>
            </tr>
            @endif
            @if(count($genres))
            <tr>
                <th scope="row">Жанры</th>
                <td>
                    @foreach($genres as $genre)
                    <a href="#{{$genre->title}}редирект на поиск по персоне и жанру">{{(!$loop->last) ? title_case($genre->title) . ',' : title_case($genre->title)}}</a>
                    @endforeach
                </td>
            </tr>
            @endif
        </tbody>
    </table>
</section>