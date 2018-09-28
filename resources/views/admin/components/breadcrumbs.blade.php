<h2>{{$title}}</h2>
<ol class="breadcrumb bg-white">
    @if(isset($parent))
    <li     class="breadcrumb-item"><a href="{{route('admin.index')}}">{{$parent}}</a></li>
    @endif
    @if(isset($parser))
    <li     class="breadcrumb-item"><a href="{{route('admin.parser.index')}}">{{$parser}}</a></li>
    @endif
    @if(isset($kinopoisk))
    <li     class="breadcrumb-item"><a href="{{route('admin.parser.kinopoisk.index')}}">{{$kinopoisk}}</a></li>
    @endif
    @if(isset($autodata))
    <li     class="breadcrumb-item"><a href="{{route('admin.parser.autodata.index')}}">{{$autodata}}</a></li>
    @endif
    @if(isset($teestore))
    <li     class="breadcrumb-item"><a href="{{route('admin.parser.teestore.index')}}">{{$teestore}}</a></li>
    @endif
    @if(isset($active))
    <li     class="breadcrumb-item active" aria-current="page">{{$active}}</li>
    @endif
</ol>