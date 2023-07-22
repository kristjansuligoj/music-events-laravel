@extends('layout.main')
@section('page-content')
    @props(['event'])
    <div class="container">
        @php
            $data['name'] = 'event';
            $data['id'] = $event->id;
        @endphp

        <x-buttons :data="$data"/>
        <hr>

        <div class="container">
            <b>Name:</b> {{ $event->name }} <br>

            <b>Address:</b> {{ $event->address  }}<br>

            <b>Date:</b> {{ $event->date }} <br>

            <b>Time:</b> {{ $event->time }} <br>

            <b>Description:</b> {{ $event->description }} <br>

            <b>Ticket price:</b> {{ $event->ticketPrice }}€<br>

            <b>Musician:</b> {{$event->musicians[0]->name}}<br>
        </div>
    </div>
@endsection

