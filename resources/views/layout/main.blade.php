<html>
    <head>
        <title>Music events organizer</title>
        <link rel="stylesheet" href="/css/bootstrap.min.css">
        <link href="https://cdn.jsdelivr.net/npm/tailwindcss/dist/tailwind.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css"/>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
    </head>
    <body class="bg-gray-100">
        <div class="p-2">
            @if(Auth::check())
                <form action="{{ route('logout') }}" method="post">
                    @csrf
                    <button type="submit"
                            class="inline-flex items-center px-4 py-2 bg-gray-800 border
                            border-transparent rounded-md text-xs text-white
                            tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900
                            focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2
                            transition ease-in-out duration-150 ml-4 text-decoration-none uppercase"
                    >Log out</button>
                </form>

                <x-button :route="'profile.edit'" :buttonText="'Profile'"/>

                <h2>Logged in user: {{Auth::user()->name}}
            @else
                <x-button :route="'register'" :buttonText="'Register'"/>

                <x-button :route="'login'" :buttonText="'Log in'"/>
            @endif
        </div>

        <div class="d-flex justify-content-between p-4">
            <x-button :route="'musicians.list'" :buttonText="'Musicians'"/>

            <x-button :route="'songs.list'" :buttonText="'Songs'"/>

            <x-button :route="'events.list'" :buttonText="'Events'"/>

            <x-button :route="'notes.list'" :buttonText="'Notes'"/>
        </div>

        @yield('page-content')
    </body>
    <footer>
        <link rel="stylesheet" href="/css/bootstrap.min.css">
    </footer>
</html>

