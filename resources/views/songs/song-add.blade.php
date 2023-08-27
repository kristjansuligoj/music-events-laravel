@extends('layout.main')
@section('page-content')
    <div class="container">
        <a
            class="btn btn-outline-dark mb-3"
            href="{{ $song ? url('songs/' . $song->id) : url('songs') }}"
        >Back</a><br>
        <hr>

        <form method="post">
            @csrf <!-- Validates the request for cross-site request forgery (session token) -->
            @isset($song['id'])
                @method('PATCH')
            @endisset

            <div class="mb-3">
                @php
                    $data = [];
                    $data['dropdown-items'] = $musicians;
                    $data['name'] = "musician";
                    $data['property'] = 'name';
                    $data['selectedOption'] = old('musician', $song?->musician->id); // String or array
                    $data['errors'] = $errors;
                @endphp
                <x-select2-dropdown :data="$data"/>
            </div>

            <div class="mb-3">
                <label for="title">Title: </label><br>
                <input
                    class="w-100"
                    required
                    type="text"
                    name="title"
                    value="{{ old('title', $song?->title) }}">
                @error('title')
                <span>{{ $errors->first('title') }}</span>
                @enderror
                <br>
                <hr>
            </div>

            <div class="mb-3">
                <label for="length">Length: </label><br>
                <input
                    class="w-100"
                    type="number"
                    min="0"
                    name="length"
                    value="{{ old('length', $song?->length) }}">
                @error('length')
                <span>{{ $errors->first('length') }}</span>
                @enderror <br>
                <hr>
            </div>

            <div class="mb-3">
                <label for="releaseDate">Release date: </label><br>
                <input
                    class="w-100"
                    type="date"
                    name="releaseDate"
                    value="{{ old('releaseDate', $song?->releaseDate) }}">
                @error('releaseDate')
                <span>{{ $errors->first('releaseDate') }}</span>
                @enderror <br>
                <hr>
            </div>

            <div class="mb-3">
                <label for="authors">Authors: </label><br>
                <input
                    class="w-100"
                    type="text"
                    name="authors"
                    value="{{ old('authors', $song?->authors) }}">
                @error('authors')
                <span>{{ $errors->first('authors') }}</span>
                @enderror <br>
                <hr>
            </div>

            @php
                $data['name'] = "genre";
                $data['options'] = \App\Enums\GenresEnum::getAllGenres();
                $data['selectedData'] = isset($song->genres) ? $song->genres : null;
                $data['errors'] = $errors;
            @endphp
            <x-checkboxes :data="$data"/>
            <hr>

            <input
                class="btn btn-success"
                type="submit"
                value="{{ isset($song->id) ? 'Edit song' : 'Add song' }}">
        </form>
    </div>
@endsection
