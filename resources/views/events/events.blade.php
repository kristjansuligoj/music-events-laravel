@extends('layout.main')
@section('page-content')
    <div class="container">
        <hr>
        <div class="d-flex justify-content-between align-items-baseline">
            <h4>List of events:</h4>
            <a
                class="btn btn-success"
                href="{{ route('events.add') }}"
                style="width:200px"
            >Add event</a>
        </div>
        <hr>
        @foreach($events as $event)
            <article class="p-2 border mt-5 d-flex justify-content-between align-items-center"
                     style="background-color: #F2F1F1">
                {{ $event->name }} <br>
                <a
                    class="btn btn-outline-danger btn-sm m-2"
                    href="/events/{{ $event->id }}"
                >More details!</a>
            </article>
            <hr>
        @endforeach
    </div>
@endsection

