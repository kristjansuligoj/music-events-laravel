<a href="/events">Back</a><br>

<form method="post">
    @csrf <!-- Validates the request for cross-site request forgery (session token) -->
    @method('PATCH')

    <label for="date">Date: <br>
        <input type="date" name="date" required value="{{ old('date', $event->date) }}">
    </label><br><hr>

    <label for="time">Time: <br>
        <input type="time" name="time" required value="{{ old('time', $event->time) }}">
    </label><br><hr>

    <label for="name">Name: <br>
        <input type="text" name="name" required value="{{ old('name', $event->name) }}">
    </label><br><hr>

    <label for="address">address: <br>
        <input type="text" name="address" required value="{{ old('address', $event->address) }}">
    </label><br><hr>

    <label for="ticketPrice">Ticket price: <br>
        <input type="number" min="0" name="ticketPrice" required value="{{ old('ticketPrice', $event->ticketPrice) }}">
    </label><br><hr>

    <label for="description">Description: <br>
        <textarea name="description">
            {{ old('description', $event->description) }}
        </textarea>
    </label><br><hr>

    <input type="submit" value="Add musician">
</form>
