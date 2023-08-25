@extends('layout.main')
@section('page-content')
    <div class="container">
        <div>
            @php
                $data['currentOrder'] = request()->input('order', '');
                $data['nextOrder'] = ( $data['currentOrder'] === 'asc') ? 'desc' : (( $data['currentOrder'] === 'desc') ? '' : 'asc');
                $data['route'] = "events.list";
                $data['fields'] = ['name', 'address', 'date', 'time', 'description', 'ticketPrice', 'musician'];
            @endphp
            <div class="mb-3">
                <x-filter :data="$data"/>
                <x-searchbar/>
            </div>
        </div>
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
        <div class="d-flex justify-content-center m-5">
            @if($events instanceof \Illuminate\Pagination\LengthAwarePaginator)
                {{$events->links()}}
            @endif
        </div>
    </div>
@endsection

