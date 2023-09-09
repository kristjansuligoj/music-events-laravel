<html>
    <head>
        <title>Music events organizer</title>
        <link rel="stylesheet" href="/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css"/>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
    </head>
    <body>
        <div class="p-2">
            @if(Auth::check())
                <form action="{{ route('logout') }}" method="post">
                    @csrf
                    <button type="submit" class="btn btn-success w-auto m-3">Logout</button>
                </form><br>

                <h2>Logged in user: {{Auth::user()->name}}
            @else
                <a
                    href="{{ route('register') }}"
                    class="btn btn-success w-auto m-3"
                >Register</a>

                <a
                    href="{{ route('login') }}"
                    class="btn btn-success w-auto m-3"
                >Login</a>
            @endif
        </div>

        <div class="d-flex justify-content-between p-4">
            <a
                href="{{ route('musicians.list') }}"
                class="btn btn-success w-25"
            >Musicians</a>

            <a
                href="{{ route('songs.list') }}"
                class="btn btn-success w-25"
            >Songs</a>

            <a
                href="{{ route('events.list') }}"
                class="btn btn-success w-25"
            >Events</a>
        </div>

        @yield('page-content')
    </body>
    <footer>
        <link rel="stylesheet" href="/css/bootstrap.min.css">
    </footer>
</html>

