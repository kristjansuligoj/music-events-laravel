<a href="/musicians">Back</a><br>

<form method="post" enctype="multipart/form-data">
    @csrf <!-- Validates the request for cross-site request forgery (session token) -->
    <?php if(isset($musician['name'])) { ?> <input type="hidden" name="_method" value="PATCH"> <?php } ?>

    <input type="file" class="form-control" name="image" /><br>

    <label for="name">Name: </label><br>
    <input required type="text" name="name" value="{{ old('name', $musician['name'] ?? '') }}">
    {{ displayErrorIfExists($errors, "name") }}
    <br>

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
    {{ displayErrorIfExists($errors, "genre") }}

    <input type="submit" value="<?php if(isset($musician['name'])) echo "Edit musician"; else echo "Add musician"; ?>">
</form>
