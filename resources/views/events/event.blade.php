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

            @if(isset($event->participants[0]))
                <b>Users that are going to this event: </b><br>
                <ul>
                    @foreach($event->participants as $participant)
                        <li>
                            {{ $participant->name }}
                        </li>
                    @endforeach
                </ul>
            @else
                <b>No users are attending this event.</b>
            @endif
        </div>

        @if(Auth::id())
            @if($event->participants->contains('id', Auth::id()))
                <form action="/events/{{$event->id}}/remove-user/{{Auth::id()}}" method="post">
                    @csrf
                    <button type="submit" class="btn btn-success w-auto m-3">NOT GOING</button>
                </form><br>
            @else
                <form action="/events/{{$event->id}}/add-user/{{Auth::id()}}" method="post">
                    @csrf
                    <button type="submit" class="btn btn-success w-auto m-3">GOING</button>
                </form><br>
            @endif
        @endif
    </div>
@endsection

