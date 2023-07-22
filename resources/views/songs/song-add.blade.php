<a href="/songs">Back</a><br>

<div>
    <form method="post">
        @csrf <!-- Validates the request for cross-site request forgery (session token) -->
        @isset($song['id'])
            @method('PATCH')
        @endisset

        @php
            $data['name'] = "musicians";
            $data['options'] = $musicians;
            $data['selectedData'] = collect(['id' => $song?->musician]);
            $data['errors'] = $errors;
        @endphp
        <x-radio-buttons :data="$data"/>

        <label for="title">Title: <br>
            <input required type="text" name="title" value="{{ old('title', $song?->title) }}">
            @error('title')
            <span>{{ $errors->first('title') }}</span>
            @enderror
        </label><br><hr>

        <label for="length">Length: <br>
            <input type="number" min="0" name="length" value="{{ old('length', $song?->length) }}">
            @error('length')
            <span>{{ $errors->first('length') }}</span>
            @enderror
        </label><br><hr>

        <label for="releaseDate">Release date: <br>
            <input type="date" name="releaseDate" value="{{ old('releaseDate', $song?->releaseDate) }}">
            @error('releaseDate')
            <span>{{ $errors->first('releaseDate') }}</span>
            @enderror
        </label><br><hr>

        <label for="authors">Authors: <br>
            <input type="text" name="authors" value="{{ old('authors', $song?->authors) }}">
            @error('authors')
            <span>{{ $errors->first('authors') }}</span>
            @enderror
        </label><br><hr>

        @php
            $data['name'] = "genre";
            $data['options'] = ["Rock", "Metal", "Rap", "Country", "Hip hop", "Jazz", "Electronic"];
            $data['selectedData'] = isset($song->genres) ? $song->genres : null;
            $data['errors'] = $errors;
        @endphp
        <x-checkboxes :data="$data"/>

        <input type="submit" value="{{ isset($song['id']) ? 'Edit song' : 'Add song' }}">
    </form>
</div>
