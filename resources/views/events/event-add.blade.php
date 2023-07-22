<a href="/events">Back</a><br>

<div>
    <form method="post">
        @csrf <!-- Validates the request for cross-site request forgery (session token) -->
        @isset($event['id'])
            @method('PATCH')
        @endisset

        <label for="date">Date: <br>
            <input type="date" name="date" required value="{{ old('date', $event?->date) }}">
            @error('date')
                <span>{{ $errors->first('date') }}</span>
            @enderror
        </label><br><hr>

        <label for="time">Time: <br>
            <input type="time" name="time" required value="{{ old('time', $event?->time) }}">
            @error('time')
                <span>{{ $errors->first('time') }}</span>
            @enderror
        </label><br><hr>

        <label for="name">Name: <br>
            <input type="text" name="name" required value="{{ old('name', $event?->name) }}">
            @error('name')
                <span>{{ $errors->first('name') }}</span>
            @enderror
        </label><br><hr>

        <label for="address">address: <br>
            <input type="text" name="address" required value="{{ old('address', $event?->address) }}">
            @error('address')
                <span>{{ $errors->first('address') }}</span>
            @enderror
        </label><br><hr>

        <label for="ticketPrice">Ticket price: <br>
            <input type="number" min="0" name="ticketPrice" required value="{{ old('ticketPrice', $event?->ticketPrice) }}">
            @error('ticketPrice')
                <span>{{ $errors->first('ticketPrice') }}</span>
            @enderror
        </label><br><hr>

        <label for="description">Description: <br>
            <textarea name="description">{{ old('description', $event?->description) }}</textarea>
        </label><br><hr>
        @error('description')
            <span>{{ $errors->first('description') }}</span>
        @enderror

        @php
            $data['name'] = "musicians";
            $data['options'] = $musicians;
            $data['selectedData'] = $event?->musicians;
            $data['errors'] = $errors;
        @endphp
        <x-radio-buttons :data="$data"/>

        <input type="submit" value="{{ isset($event['id']) ? 'Edit event' : 'Add event' }}">
    </form>
</div>
