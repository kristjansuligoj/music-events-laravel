<a href="/songs">Back</a><br>

<form method="post">
    @csrf <!-- Validates the request for cross-site request forgery (session token) -->
    @isset($song['id'])
        @method('PATCH')
    @endisset

    <x-radio-buttons :data="$musicians"/>

    <label for="title">Title: <br>
        <input required type="text" name="title" value="{{ old('title', $song['title'] ?? '') }}">
        {{ displayErrorIfExists($errors, "title") }}
    </label><br><hr>

    <label for="length">Length: <br>
        <input type="number" min="0" name="length" value="{{ old('length', $song['length'] ?? '') }}">
        {{ displayErrorIfExists($errors, "length") }}
    </label><br><hr>

    <label for="releaseDate">Release date: <br>
        <input type="date" name="releaseDate" value="{{ old('releaseDate', $song['releaseDate'] ?? '') }}">
        {{ displayErrorIfExists($errors, "releaseDate") }}
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

    <input type="submit" value="{{ isset($song['id']) ? 'Edit song' : 'Add song' }}">
</form>
