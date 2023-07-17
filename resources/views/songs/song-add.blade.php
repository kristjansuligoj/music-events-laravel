<a href="/songs">Back</a><br>

<form method="post">
    @csrf <!-- Validates the request for cross-site request forgery (session token) -->
    <?php if(isset($song['title'])) { ?> <input type="hidden" name="_method" value="PATCH"> <?php } ?>

    <label for="releaseDate">Release date: <br>
        <input type="date" name="releaseDate" value="{{ old('releaseDate', $song['releaseDate'] ?? '') }}">
        {{ displayErrorIfExists($errors, "releaseDate") }}
    </label><br><hr>

    <label for="title">Title: <br>
        <input required type="text" name="title" value="{{ old('title', $song['title'] ?? '') }}">
        {{ displayErrorIfExists($errors, "title") }}
    </label><br><hr>

    <label for="length">Length: <br>
        <input type="number" min="0" name="length" value="{{ old('length', $song['length'] ?? '') }}">
        {{ displayErrorIfExists($errors, "length") }}
    </label><br><hr>

    <label for="authors">Authors: <br>
        <input type="text" name="authors" value="{{ old('authors', $song['authors'] ?? '') }}">
        {{ displayErrorIfExists($errors, "authors") }}
    </label><br><hr>

    <label for="genre">Genre: </label><br>
    <input type="checkbox" id="genre1" name="genre[]" value="Rock">
    <label for="genre1">Rock</label><br>

    <input type="checkbox" id="genre2" name="genre[]" value="Metal">
    <label for="genre2">Metal</label><br>

    <input type="checkbox" id="genre3" name="genre[]" value="Rap">
    <label for="genre3">Rap</label><br>

    <input type="checkbox" id="genre4" name="genre[]" value="Country">
    <label for="genre3">Country</label><br>

    <input type="checkbox" id="genre5" name="genre[]" value="Hip hop">
    <label for="genre3">Hip hop</label><br>

    <input type="checkbox" id="genre6" name="genre[]" value="Jazz">
    <label for="genre3">Jazz</label><br>

    <input type="checkbox" id="genre7" name="genre[]" value="Electronic">
    <label for="genre3">Electronic</label><br><hr>

    <?php foreach($musicians as $musician): ?>
        <input type="radio" name="musician" value="{{ $musician->id }}">
        <label for="">{{ $musician->name }}</label><br>
    <?php endforeach; ?><hr>

    <input type="submit" value="<?php if(isset($song['title'])) echo "Edit song"; else echo "Add song"; ?>">
</form>
