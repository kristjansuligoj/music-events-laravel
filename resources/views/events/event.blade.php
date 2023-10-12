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
                    <button type="submit"
                            class="inline-flex items-center px-4 py-2 bg-red-500 border
                            border-transparent rounded-md text-xs text-white
                            tracking-widest hover:bg-red-700 focus:bg-red-700 active:bg-red-900
                            focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2
                            transition ease-in-out duration-150 ml-4 text-decoration-none uppercase"
                    >NOT GOING</button>
                </form><br>
            @else
                <form action="/events/{{$event->id}}/add-user/{{Auth::id()}}" method="post">
                    @csrf
                    <button type="submit"
                            class="inline-flex items-center px-4 py-2 bg-green-500 border
                            border-transparent rounded-md text-xs text-white
                            tracking-widest hover:bg-green-700 focus:bg-green-700 active:bg-green-900
                            focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2
                            transition ease-in-out duration-150 ml-4 text-decoration-none uppercase"
                    >GOING</button>
                </form><br>
            @endif
        @endif
    </div>
@endsection

