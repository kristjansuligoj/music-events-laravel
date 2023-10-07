@props(['data'])

<div class="d-flex justify-content-around m-5">
    <a
        class="inline-flex items-center px-4 py-2 bg-green-500 border
                border-transparent rounded-md text-xs text-white
                tracking-widest hover:bg-green-700 focus:bg-green-700 active:bg-green-900
                focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2
                transition ease-in-out duration-150 ml-4 text-decoration-none uppercase h-100"
        href="/{{ $data['name'] }}s/edit/{{ $data['id'] }}"
    >Edit {{ $data['name'] }}</a>

    <form method="post" action="/{{ $data['name'] }}s/remove/{{ $data['id'] }}">
        @csrf
        @method('DELETE')

        <input
            onclick="return confirm('Are you sure?')"
            class="inline-flex items-center px-4 py-2 bg-red-800 border
                   border-transparent rounded-md text-xs text-white
                   tracking-widest hover:bg-red-700 focus:bg-red-700 active:bg-red-900
                   focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2
                   transition ease-in-out duration-150 ml-4 text-decoration-none uppercase h-100"
            type="submit"
            value="Remove {{ $data['name'] }}"
        >
    </form>
</div>
