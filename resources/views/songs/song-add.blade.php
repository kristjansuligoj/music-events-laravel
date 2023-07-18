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

    @php
        $data = [
            'genres' => isset($song['genres']) ? $song['genres'] : null,
            'errors' => $errors,
        ];
    @endphp

    <x-genre-checkboxes :data="$data" />

    <input type="checkbox" id="genre7" name="genre[]" value="Electronic">
    <label for="genre3">Electronic</label><br><hr>

    <?php foreach($musicians as $musician): ?>
        <input type="radio" name="musician" value="{{ $musician->id }}">
        <label for="">{{ $musician->name }}</label><br>
    <?php endforeach; ?><hr>

    <input type="submit" value="<?php if(isset($song['title'])) echo "Edit song"; else echo "Add song"; ?>">
</form>
