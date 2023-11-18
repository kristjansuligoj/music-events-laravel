@extends('layout.main')
@section('page-content')
    <div class="container p-5 sm:p-8 bg-white shadow sm:rounded-lg">
        <div>
            @php
                $data['currentOrder'] = request()->input('order', '');
                $data['sortOrder'] = $sortOrder;
                $data['route'] = "events.list";
                $data['fields'] = array_keys($sortOrder);
            @endphp
            <div class="mb-3">
                <x-filter :data="$data"/>
                <x-searchbar/>
            </div>
        </div>
        <div class="d-flex justify-content-between align-items-baseline mt-5">
            <h4>Events:</h4>

            <x-button :route="'events.add'" :buttonText="'Add event'"/>
        </div>
        @foreach($events as $event)
            <article class="p-3 border mt-5 bg-gray-100 shadow sm:rounded-lg">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <b>Name:</b> {{ $event->name }}<br>
                        <b>Date:</b> {{ $event->date }}<br>
                        <b>Ticket price:</b> {{ $event->ticketPrice }}€ <br>
                        <b>Musician:</b> {{ $event->musicians[0]->name }} <br>
                    </div>
                    <div class="text-center">
                        <x-button :href="'/events/' . $event->id" :buttonText="'More details!'"/>
                    </div>
                </div>
            </article>
        @endforeach
        <div class="d-flex justify-content-center m-5">
            @if($events instanceof \Illuminate\Pagination\LengthAwarePaginator)
                {{$events->links()}}
            @endif
        </div>
    </div>
@endsection

