<form action="" class="flex items-center">
    @if(request()->has('showAttending'))
        <input type="hidden" name="showAttending" value="{{ request('showAttending') }}">
    @endif
    <input
        type="text"
        placeholder="Search by keyword . . ."
        name="keyword"
        class="form-control border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 mb-2"
        value="{{ request()->query('keyword') }}"
    >
    <input type="submit" value="Search" class="inline-flex items-center px-4 py-2 bg-gray-800 border
        border-transparent rounded-md text-xs text-white
        tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900
        focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2
        transition ease-in-out duration-150 ml-4 text-decoration-none uppercase"
    >
</form>
