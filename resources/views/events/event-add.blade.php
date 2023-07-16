<a href="/events">Back</a><br>

<form method="post">
    @csrf <!-- Validates the request for cross-site request forgery (session token) -->

    <label for="date">Date: <br>
        <input type="date" name="date" required>
    </label><br><hr>

    <label for="time">Time: <br>
        <input type="time" name="time" required>
    </label><br><hr>

    <label for="name">Name: <br>
        <input type="text" name="name" required>
    </label><br><hr>

    <label for="address">address: <br>
        <input type="text" name="address" required>
    </label><br><hr>

    <label for="ticketPrice">Ticket price: <br>
        <input type="number" min="0" name="ticketPrice"required>
    </label><br><hr>

    <label for="description">Description: <br>
        <textarea name="description">
        </textarea>
    </label><br><hr>

    <label for="genre">Genre: </label><br>
    <input type="checkbox" id="genre1" name="genre[]" value="Metal">
    <label for="genre1">Metal</label><br>

    <input type="checkbox" id="genre2" name="genre[]" value="Hip hop">
    <label for="genre2">Hip hop</label><br>

    <input type="checkbox" id="genre3" name="genre[]" value="Rap">
    <label for="genre3">Rap</label><br><hr>

    <input type="submit" value="Add musician">
</form>
