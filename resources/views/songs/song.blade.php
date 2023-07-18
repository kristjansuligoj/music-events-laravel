<a href="/">Back</a><br>

<h3>Songs page</h3>

<body>
    <article>
        <b>Name:</b> {{ $song->title }}<br>

        <b>Genre:</b><br>
        <?php echo printArray($song->genres, "name") ?>

        <b>Length:</b> {{ $song->length }} <br>

        <b>Release date:</b> {{ $song->releaseDate }} <br>

        <b>Authors:</b><br>
        <?php echo printArray($song->authors, "name") ?>

        <b>Musician:</b>{{ $song->musician->name }} <br>

        <hr>
        <form method="post" action="/songs/remove/{{$song->id }}">
            @csrf
            @method("DELETE")

@php
    $element = [
        'name' => 'song',
        'id' => $song->id,
    ];
@endphp

<x-buttons :element="$element" />
