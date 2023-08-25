@extends('layout.main')
@section('page-content')
    <div class="container">
        <div>
            @php
                $data['currentOrder'] = request()->input('order', '');
                $data['nextOrder'] = ( $data['currentOrder'] === 'asc') ? 'desc' : (( $data['currentOrder'] === 'desc') ? '' : 'asc');
                $data['route'] = "songs.list";
                $data['fields'] = ['title', 'genre', 'length', 'releaseDate', 'authors', 'musician'];
            @endphp
            <div class="mb-3">
                <x-filter :data="$data"/>
                <x-searchbar/>
            </div>
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
        <div class="d-flex justify-content-center m-5">
            @if($songs instanceof \Illuminate\Pagination\LengthAwarePaginator)
                {{$songs->links()}}
            @endif
        </div>
    </div>
@endsection
