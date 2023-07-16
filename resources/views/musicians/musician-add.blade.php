<a href="/musicians">Back</a><br>

<form method="post">
    @csrf <!-- Validates the request for cross-site request forgery (session token) -->

    <label for="name">Name: </label><br>
    <input type="text" name="name"><br><hr>

    <label for="genre">Genre: </label><br>
    <input type="checkbox" id="genre1" name="genre[]" value="Metal">
    <label for="genre1">Metal</label><br>

    <input type="checkbox" id="genre2" name="genre[]" value="Hip hop">
    <label for="genre2">Hip hop</label><br>

    <input type="checkbox" id="genre3" name="genre[]" value="Rap">
    <label for="genre3">Rap</label><br>

    <input type="submit" value="Add musician">
</form>
