@extends('layout.main')
@section('page-content')
    <div class="container">
        <a
            class="btn btn-outline-dark mb-3"
            href="{{ $event ? url('events/' . $event->id) : url('events') }}"
        >Back</a><br>
        <hr>

        <form method="post">
            @csrf <!-- Validates the request for cross-site request forgery (session token) -->
            @isset($event['id'])
                @method('PATCH')
            @endisset

            <div class="mb-3">
                <label for="date">Date: </label><br>
                <input
                    class="w-100"
                    type="date" name="date" required value="{{ old('date', $event?->date) }}"
                >
                @error('date')
                <span>{{ $errors->first('date') }}</span>
                @enderror <br>
                <hr>
            </div>


            <div class="mb-3">
                <label for="time">Time: </label><br>
                <input
                    class="w-100"
                    type="time" name="time" required value="{{ old('time', $event?->time) }}"
                >
                @error('time')
                <span>{{ $errors->first('time') }}</span>
                @enderror <br>
                <hr>
            </div>

            <div class="mb-3">
                <label for="name">Name: </label><br>
                <input
                    class="w-100"
                    type="text" name="name" required value="{{ old('name', $event?->name) }}"
                >
                @error('name')
                <span>{{ $errors->first('name') }}</span>
                @enderror <br>
                <hr>
            </div>

            <div class="mb-3">
                <label for="address">Address: </label><br>
                <input
                    class="w-100"
                    type="text" name="address" required value="{{ old('address', $event?->address) }}"
                >
                @error('address')
                <span>{{ $errors->first('address') }}</span>
                @enderror <br>
                <hr>
            </div>

            <div class="mb-3">
                <label for="ticketPrice">Ticket price: </label><br>
                <input
                    class="w-100"
                    type="number" min="0" name="ticketPrice" required
                    value="{{ old('ticketPrice', $event?->ticketPrice) }}"
                >
                @error('ticketPrice')
                <span>{{ $errors->first('ticketPrice') }}</span>
                @enderror <br>
                <hr>
            </div>

            <div class="mb-3">
                <label for="description">Description: </label><br>
                <textarea
                    class="w-100"
                    name="description">{{ old('description', $event?->description) }}</textarea>
                @error('description')
                <span>{{ $errors->first('description') }}</span>
                @enderror <br>
                <hr>
            </div>

            <div class="mb-3">
                @php
                    $data = [];
                    $data['dropdown-items'] = $musicians;
                    $data['name'] = "musician";
                    $data['property'] = 'name';
                    $data['selectedOption'] = old('musician', $event?->musicians[0]->id); // String or array
                    $data['errors'] = $errors;
                @endphp
                <x-select2-dropdown :data="$data"/>
            </div>

            <input
                class="btn btn-success"
                type="submit"
                value="{{ isset($event->id) ? 'Edit event' : 'Add event' }}">
        </form>
    </div>
@endsection
