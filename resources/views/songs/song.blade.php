@props(['song'])

<b>Name:</b> {{ $song->title }}<br>

<b>Genre:</b><br>
<?php echo printArray($song->genres, "name") ?>

<b>Length:</b> {{ $song->length }} <br>

<b>Release date:</b> {{ $song->releaseDate }} <br>

<b>Authors:</b><br>
<?php echo printArray($song->authors, "name") ?>

@if (isset($song->musicians->name))
    <b>Musician:</b> {{ $song->musicians->name }} <br>
@else
    <b>No musician selected</b>
@endif

@php
    $element = [
        'name' => 'song',
        'id' => $song->id,
    ];
@endphp

<x-buttons :element="$element" />
