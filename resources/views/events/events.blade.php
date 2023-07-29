@extends('layout.main')
@section('page-content')
    <div class="container">
        <div>
            @php
                $currentOrder = request()->input('order', '');
                $nextOrder = ($currentOrder === 'asc') ? 'desc' : (($currentOrder === 'desc') ? '' : 'asc');
            @endphp
            Sort by:
            <th>
                <a href="{{ route('events.list', ['order' => $nextOrder, 'field' => 'name']) }}">Name</a>
            </th>
            <th>
                <a href="{{ route('events.list', ['order' => $nextOrder, 'field' => 'address']) }}">Address</a>
            </th>
            <th>
                <a href="{{ route('events.list', ['order' => $nextOrder, 'field' => 'date']) }}">Date</a>
            </th>
            <th>
                <a href="{{ route('events.list', ['order' => $nextOrder, 'field' => 'time']) }}">Time</a>
            </th>
            <th>
                <a href="{{ route('events.list', ['order' => $nextOrder, 'field' => 'description']) }}">Description</a>
            </th>
            <th>
                <a href="{{ route('events.list', ['order' => $nextOrder, 'field' => 'ticketPrice']) }}">TicketPrice</a>
            </th>
            <th>
                <a href="{{ route('events.list', ['order' => $nextOrder, 'field' => 'musician']) }}">Musician</a>
            </th><br>
            Order: {{ $currentOrder }}
            <form action="">
                <input type="text" placeholder="Search by keyword . . .">
                <input type="submit" value="Search">
            </form>
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

