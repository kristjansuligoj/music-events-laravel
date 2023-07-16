<a href="/songs">Back</a><br>

<form method="post">
    @csrf <!-- Validates the request for cross-site request forgery (session token) -->

    <label for="releaseDate">Release date: <br>
        <input type="date" name="releaseDate">
    </label><br><hr>

    <label for="title">Title: <br>
        <input type="text" name="title">
    </label><br><hr>

    <label for="length">Length: <br>
        <input type="number" min="0" name="length">
    </label><br><hr>

    <label for="authors">Authors: <br>
        <input type="text" name="authors">
    </label><br><hr>

    <label for="genre">Genre: </label><br>
    <input type="checkbox" id="genre1" name="genre[]" value="Metal">
    <label for="genre1">Metal</label><br>

    <input type="checkbox" id="genre2" name="genre[]" value="Hip hop">
    <label for="genre2">Hip hop</label><br>

    <input type="checkbox" id="genre3" name="genre[]" value="Rap">
    <label for="genre3">Rap</label><br><hr>

    <?php foreach($musicians as $musician): ?>
        <input type="radio" name="musician" value="<?php echo $musician->uuid; ?>">
        <label for=""><?php echo $musician->name; ?></label><br>
    <?php endforeach; ?><hr>


    <input type="submit" value="Add song">
</form>
