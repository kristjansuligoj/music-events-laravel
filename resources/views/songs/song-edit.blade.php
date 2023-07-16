<a href="/songs">Back</a><br>

<form method="post">
    @csrf <!-- Validates the request for cross-site request forgery (session token) -->
    @method('PATCH')

    <label for="releaseDate"><b>Release date:</b> <br>
        <input type="date" name="releaseDate" value="{{ old('releaseDate', $song->releaseDate) }}" required>
    </label><br><hr>

    <label for="title"><b>Title:</b> <br>
        <input type="text" name="title" value="{{ old('title', $song->title) }}" required>
    </label><br><hr>

    <label for="length"><b>Length:</b> <br>
        <input type="number" min="0" name="length" value="{{ old('length', $song->length) }}" required>
    </label><br><hr>

    <label for="authors"><b>Authors:</b> <br>
        <input type="text" name="authors" value="{{ old('authors', $song->authors->pluck('name')->implode(',')) }}" required>
    </label><br><hr>

    <label for="genre"><b>Genre:</b> </label><br>
    <input type="checkbox" id="genre1" name="genre[]" value="Metal" {{ (isset($song->genre) && in_array("Metal", $song->genres) || (!isset($song)) && in_array("Metal", old('genres', []))) ? "checked=\"checked\"" : "" }}>
    <label for="genre1">Metal</label><br>

    <input type="checkbox" id="genre2" name="genre[]" value="Hip hop" {{ (isset($song->genre) && in_array("Hip hop", $song->genres) || (!isset($song)) && in_array("Hip hop", old('genres', []))) ? "checked=\"checked\"" : "" }}>
    <label for="genre2">Hip hop</label><br>

    <input type="checkbox" id="genre3" name="genre[]" value="Rap" {{ (isset($song->genre) && in_array("Rap", $song->genres) || (!isset($song)) && in_array("Rap", old('genres', []))) ? "checked=\"checked\"" : "" }}>
    <label for="genre3">Rap</label><br><hr>

    <?php if(isset($musician) && count($musician) == 0) echo "No musicians added yet.";
    else {
        echo "<b>Musicians: </b><br>";
        foreach($musicians as $musician): ?>
            <input type="radio" name="musician" value="<?php echo $musician->id; ?>" <?php if ($musician->id == $song->musician) echo "checked";?>>
            <label for=""><?php echo $musician->name; ?></label><br>
        <?php endforeach;
    }?><hr>

    <input type="submit" value="Add song">
</form>
