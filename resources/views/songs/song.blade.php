@extends('layout.main')
@section('page-content')
    @props(['song'])
    <div class="container p-5 sm:p-8 bg-white shadow sm:rounded-lg">
        @if(Auth::check() && Auth::user()->id === $song->user_id)
            @php
                $data['name'] = 'song';
                $data['id'] = $song->id;
            @endphp

            <x-buttons :data="$data"/>
            <hr>
        @endif

        <div class="container">
            <div>
                Added by user: <b>{{$song->user->name}}</b>
            </div>
            <hr>

            <b>Name:</b> {{ $song->title }}<br>

            <b>Genre:</b><br>
            <?php echo printArray($song->genres, "name"); ?>

            <b>Length:</b> {{ $song->length }} <br>

            <b>Release date:</b> {{ $song->releaseDate }} <br>

            <b>Authors:</b><br>
            <?php echo printArray($song->authors, "name"); ?>

            @if (isset($song->musician->name))
                <b>Musician:</b> {{ $song->musician->name }} <br>
            @else
                <b>No musician selected</b>
            @endif
        </div>
    </div>
@endsection
