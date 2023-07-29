@extends('layout.main')
@section('page-content')
    @props(['song'])
    <div class="container">
        @php
            $data['name'] = 'song';
            $data['id'] = $song->id;
        @endphp

        <x-buttons :data="$data"/>
        <hr>

        <div class="container">
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
