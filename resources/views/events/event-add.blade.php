@extends('layout.main')
@section('page-content')
    <div class="container w-full sm:max-w-md mt-6 p-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
        <x-button :href="$event ? url('events/' . $event->id) : url('events')" :buttonText="'Back'"/>

        <h6 class="mt-3">Fields that have * are required!</h6>

        <form method="post" class="mt-4">
            @csrf <!-- Validates the request for cross-site request forgery (session token) -->
            @isset($event['id'])
                @method('PATCH')
            @endisset

            <div class="mb-3">
                <label for="date" class="block font-medium text-sm text-gray-700 mb-2">* Date: </label>
                <input
                    class="form-control border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block w-full"
                    type="date" name="date" required value="{{ old('date', $event?->date) }}"
                >
                @error('date')
                <span class="fw-bold">{{ $errors->first('date') }}</span>
                @enderror <br>
            </div>


            <div class="mb-3">
                <label for="time" class="block font-medium text-sm text-gray-700 mb-2">* Time: </label>
                <input
                    class="form-control border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block w-full"
                    type="time" name="time" required value="{{ old('time', $event?->time) }}"
                >
                @error('time')
                <span class="fw-bold">{{ $errors->first('time') }}</span>
                @enderror <br>
            </div>

            <div class="mb-3">
                <label for="name" class="block font-medium text-sm text-gray-700 mb-2">* Name: </label>
                <input
                    class="form-control border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block w-full"
                    type="text" name="name" required value="{{ old('name', $event?->name) }}"
                >
                @error('name')
                <span class="fw-bold">{{ $errors->first('name') }}</span>
                @enderror <br>
            </div>

            <div class="mb-3">
                <label for="address" class="block font-medium text-sm text-gray-700 mb-2">* Address: </label>
                <input
                    class="form-control border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block w-full"
                    type="text" name="address" required value="{{ old('address', $event?->address) }}"
                >
                @error('address')
                <span class="fw-bold">{{ $errors->first('address') }}</span>
                @enderror <br>
            </div>

            <div class="mb-3">
                <label for="ticketPrice" class="block font-medium text-sm text-gray-700 mb-2">* Ticket price: </label>
                <input
                    class="form-control border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block w-full"
                    type="number" min="0" name="ticketPrice" required
                    value="{{ old('ticketPrice', $event?->ticketPrice) }}"
                >
                @error('ticketPrice')
                <span class="fw-bold">{{ $errors->first('ticketPrice') }}</span>
                @enderror <br>
            </div>

            <div class="mb-3">
                <label for="description" class="block font-medium text-sm text-gray-700 mb-2">* Description: </label>
                <textarea
                    class="form-control border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block w-full"
                    name="description">{{ old('description', $event?->description) }}</textarea>
                @error('description')
                <span class="fw-bold">{{ $errors->first('description') }}</span>
                @enderror <br>
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

                <label for="musician" class="block font-medium text-sm text-gray-700 mb-2">* Musician: </label>
                <x-select2-dropdown :data="$data"/>
            </div>

            <input
                class="inline-flex items-center px-4 py-2 bg-green-500 border
                        border-transparent rounded-md text-xs text-white
                        tracking-widest hover:bg-green-700 focus:bg-green-700 active:bg-green-900
                        focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2
                        transition ease-in-out duration-150 ml-4 text-decoration-none uppercase"
                type="submit"
                value="{{ isset($event->id) ? 'Edit event' : 'Add event' }}">
        </form>
    </div>
@endsection
