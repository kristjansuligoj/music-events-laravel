@extends('layout.main')
@section('page-content')
    <div class="container">
        <div>
            @php
                $currentOrder = request()->input('order', '');
                $nextOrder = ($currentOrder === 'asc') ? 'desc' : (($currentOrder === 'desc') ? '' : 'asc');
            @endphp
            Sort by:
            <th>
                <a href="{{ route('songs.list', ['order' => $nextOrder, 'field' => 'title']) }}">Title</a>
            </th>
            <th>
                <a href="{{ route('songs.list', ['order' => $nextOrder, 'field' => 'genre']) }}">Genre</a>
            </th>
            <th>
                <a href="{{ route('songs.list', ['order' => $nextOrder, 'field' => 'length']) }}">Length</a>
            </th>
            <th>
                <a href="{{ route('songs.list', ['order' => $nextOrder, 'field' => 'releaseDate']) }}">Release date</a>
            </th>
            <th>
                <a href="{{ route('songs.list', ['order' => $nextOrder, 'field' => 'authors']) }}">Authors</a>
            </th>
            <th>
                <a href="{{ route('songs.list', ['order' => $nextOrder, 'field' => 'musician']) }}">Musician</a>
            </th><br>
            Order: {{ $currentOrder }}
            <form action="">
                <input type="text" placeholder="Search by keyword . . .">
                <input type="submit" value="Search">
            </form>
        </div>
        <hr>
        <div class="d-flex justify-content-between align-items-baseline">
            <h4>List of songs:</h4>
            <a
                class="btn btn-success"
                href="{{ route('songs.add') }}"
                style="width:200px"
            >Add song</a>
        </div>
        <hr>
        @foreach($songs as $song)
            <article class="p-2 border mt-5 d-flex justify-content-between align-items-center"
                     style="background-color: #F2F1F1">
                {{ $song->title }} <br>
                <a
                    class="btn btn-outline-danger btn-sm m-2"
                    href="/songs/{{ $song->id }}"
                >More details!</a>
            </article>
            <hr>
        @endforeach
    </div>
@endsection
