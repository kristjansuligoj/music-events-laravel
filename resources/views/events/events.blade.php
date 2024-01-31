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
                <x-filter :data="$data"/><br>
                @if(Auth::check())
                    <form id="filterForm" action="{{ route('events.list') }}" method="get">
                        <label for="showAttending">
                            @php
                                $order = request('order');
                                $field = request('field');
                                $keyword = request('keyword');
                            @endphp

                            @if(isset($order))
                                <input type="hidden" name="order" value="{{ $order }}">
                            @endif

                            @if(isset($field))
                                <input type="hidden" name="field" value="{{ $field }}">
                            @endif

                            @if(isset($keyword))
                                <input type="hidden" name="keyword" value="{{ $keyword }}">
                            @endif

                            <input
                                type="checkbox"
                                class="m-2"
                                name="showAttending"
                                id="showAttending"
                                {{ request()->has('showAttending') ? 'checked' : '' }}
                                onchange="submitForm()"
                            >
                            Only show events I'm attending
                        </label>
                    </form>

                    <script>
                        function submitForm() {
                            document.getElementById('filterForm').submit();
                        }
                    </script>
                @endif
                <x-searchbar/>
            </div>
        </div>
        <div class="d-flex justify-content-between align-items-baseline mt-5">
            <h4>Events:</h4>

            @if(Auth::check())
                <x-button :route="'events.add'" :buttonText="'Add event'"/>
            @endif
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
                        <x-button :href="'/events/' . $event->id" :buttonText="'More details'"/>
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

