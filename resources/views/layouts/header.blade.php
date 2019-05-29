<div class="header">
    <div class="nav">
        <div class="logo"><a href="{{ url('/') }}">{{ config('app.name', 'Laravel') }}</a></div>
        <div class="menu">
            <ul class="unstyled">
                @foreach($types as $type)
                <li>
                    <a class="@if(isset($movie->type))
                            {{$type->slug === $movie->type->slug ? 'active' : ''}}
                        @else
                            {{mb_stripos(url()->current(), route('type', $type->slug)) === 0 ? 'active' : ''}}
                        @endif"
                        href="{{ route('type') }}/{{$type->slug}}">
                        {{$type->title}}
                    </a>
                </li>
                @endforeach
            </ul>
        </div>
        <div class="right-nav">
            <div class="search-components">
                <form>
                    <input type="text" class="search">
                    <button>O</button>
                </form>
                <a href="#">Расширенный поиск</a>
            </div>
            @guest
            <a href="{{ route('login') }}"><div>Sign-In</div></a>
            @else
            {{ Auth::user()->name }}
            <a href="{{ route('logout') }}"
               onclick="event.preventDefault();
                       document.getElementById('logout-form').submit();">
                <div>Logout</div>
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
            @endguest
        </div>
    </div>
</div>