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
                <span class="fw-bold">{{ $errors->first('date') }}</span>
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
                <span class="fw-bold">{{ $errors->first('time') }}</span>
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
                <span class="fw-bold">{{ $errors->first('name') }}</span>
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
                <span class="fw-bold">{{ $errors->first('address') }}</span>
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
                <span class="fw-bold">{{ $errors->first('ticketPrice') }}</span>
                @enderror <br>
                <hr>
            </div>

            <div class="mb-3">
                <label for="description">Description: </label><br>
                <textarea
                    class="w-100"
                    name="description">{{ old('description', $event?->description) }}</textarea>
                @error('description')
                <span class="fw-bold">{{ $errors->first('description') }}</span>
                @enderror <br>
                <hr>
            </div>

            <div class="mb-3">
                @php
                    $data['name'] = "musicians";
                    $data['options'] = $musicians;
                    $data['selectedData'] = $event?->musicians;
                    $data['errors'] = $errors;
                @endphp
                <x-radio-buttons :data="$data"/>
            </div>

            <input
                class="btn btn-success"
                type="submit"
                value="{{ isset($event->id) ? 'Edit event' : 'Add event' }}">
        </form>
    </div>
@endsection
