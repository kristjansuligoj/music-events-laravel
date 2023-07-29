<html>
    <head>
        <title>Music events organizer</title>
        <link rel="stylesheet" href="/css/bootstrap.min.css">
    </head>
    <body>
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

