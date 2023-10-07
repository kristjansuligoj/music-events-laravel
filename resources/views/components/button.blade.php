@props(['href', 'route', 'buttonText'])

<a class="inline-flex items-center px-4 py-2 bg-gray-800 border
        border-transparent rounded-md text-xs text-white
        tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900
        focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2
        transition ease-in-out duration-150 ml-4 text-decoration-none uppercase"
   href="{{ (isset($href) && strlen($href) > 0) ? $href : route($route) }}"
>{{ $buttonText }}</a>
