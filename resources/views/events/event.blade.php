@extends('layout.main')
@section('page-content')
    @props(['event'])
    <div class="container p-5 sm:p-8 bg-white shadow sm:rounded-lg">
        @if(Auth::check() && Auth::user()->id === $event->user_id)
            @php
                $data['name'] = 'event';
                $data['id'] = $event->id;
            @endphp

            <x-buttons :data="$data"/>
            <hr>
        @endif

        <div class="container">
            <div>
                Added by user: <b>{{$event->user->name}}</b>
            </div>
            <hr>

            <b>Name:</b> {{ $event->name }} <br>

            <b>Address:</b> {{ $event->address  }}<br>

            <div class="container">
                <div id="map" style="height: 400px;"></div>

                <script>
                    function initMap() {
                        const address = '{{ $event->address }}';
                        const geocoder = new google.maps.Geocoder();

                        geocoder.geocode({ 'address': address }, function(results, status) {
                            if (status === google.maps.GeocoderStatus.OK) {
                                const map = new google.maps.Map(document.getElementById('map'), {
                                    zoom: 13,
                                    center: results[0].geometry.location
                                });

                                new google.maps.Marker({
                                    map: map,
                                    position: results[0].geometry.location,
                                    title: "{{ $event->name }} Location"
                                });
                            } else {
                                alert('Geocode was not successful for the following reason: ' + status);
                            }
                        });
                    }
                </script>
                <script src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_API_KEY') }}&callback=initMap" async defer></script>
            </div>

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

