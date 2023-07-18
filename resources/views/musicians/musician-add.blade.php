<a href="/musicians">Back</a><br>

<form method="post" enctype="multipart/form-data">
    @csrf <!-- Validates the request for cross-site request forgery (session token) -->
    @isset($musician['id'])
        @method('PATCH')
    @endisset

    <input type="file" class="form-control" name="image" required/><br>

    <label for="name">Name: </label><br>
    <input required type="text" name="name" value="{{ old('name', $musician['name'] ?? '') }}">
    {{ displayErrorIfExists($errors, "name") }}
    <br>

    <?php if(isset($musician['genres'])) {
        $data['genres'] = $musician['genres'];
        $data['errors'] = $errors;
        ?>

        <x-genre-checkboxes :data="$data"></x-genre-checkboxes>
    <?php } else { ?>
        <x-genre-checkboxes></x-genre-checkboxes>
    <?php } ?>

    <input type="submit" value="{{ isset($musician['id']) ? 'Edit musician' : 'Add musician' }}">
</form>
