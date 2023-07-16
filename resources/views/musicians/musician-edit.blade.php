<a href="/musicians/add">Back</a><br>

<form method="post">
    @csrf <!-- Validates the request for cross-site request forgery (session token) -->
    @method('PATCH')

    <label for="name">Name:
        <input type="text" name="name" value="{{ old('name', $musician->name) }}">
    </label><br><hr>

    <label for="genre">Genre: </label><br>
    <input type="checkbox" id="genre1" name="genre[]" value="Metal" {{ (isset($musician->genre) && in_array("Metal", $musician->genre) || (!isset($musician)) && in_array("Metal", old('genre', []))) ? "checked=\"checked\"" : "" }}>
    <label for="genre1">Metal</label><br>

    <input type="checkbox" id="genre2" name="genre[]" value="Hip hop" {{ (isset($musician->genre) && in_array("Hip hop", $musician->genre) || (!isset($musician)) && in_array("Hip hop", old('genre', []))) ? "checked=\"checked\"" : "" }}>
    <label for="genre2">Hip hop</label><br>

    <input type="checkbox" id="genre3" name="genre[]" value="Rap" {{ (isset($musician->genre) && in_array("Rap", $musician->genre) || (!isset($musician)) && in_array("Rap", old('genre', []))) ? "checked=\"checked\"" : "" }}>
    <label for="genre3">Rap</label><br>

    <input type="submit" value="Add musician">
</form>
