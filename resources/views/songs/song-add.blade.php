@extends('layout.main')
@section('page-content')
    <div class="container w-full sm:max-w-md mt-6 p-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
        <x-button :href="$song ? url('songs/' . $song->id) : url('songs')" :buttonText="'Back'"/>

        <form method="post" class="mt-4">
            @csrf <!-- Validates the request for cross-site request forgery (session token) -->
            @isset($song['id'])
                @method('PATCH')
            @endisset

            <div class="mb-3">
                <label for="musician" class="block font-medium text-sm text-gray-700 mb-2">Musician: </label>
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
                <label for="title" class="block font-medium text-sm text-gray-700 mb-2">Title: </label>
                <input
                    class="form-control border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block w-full"
                    required
                    type="text"
                    name="title"
                    value="{{ old('title', $song?->title) }}">
                @error('title')
                <span class="fw-bold">{{ $errors->first('title') }}</span>
                @enderror <br>
            </div>

            <div class="mb-3">
                <label for="length" class="block font-medium text-sm text-gray-700 mb-2">Length: </label>
                <input
                    class="form-control border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block w-full"
                    type="number"
                    min="0"
                    name="length"
                    value="{{ old('length', $song?->length) }}">
                @error('length')
                <span class="fw-bold">{{ $errors->first('length') }}</span>
                @enderror <br>
            </div>

            <div class="mb-3">
                <label for="releaseDate" class="block font-medium text-sm text-gray-700 mb-2">Release date: </label>
                <input
                    class="form-control border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block w-full"
                    type="date"
                    name="releaseDate"
                    value="{{ old('releaseDate', $song?->releaseDate) }}">
                @error('releaseDate')
                <span class="fw-bold">{{ $errors->first('releaseDate') }}</span>
                @enderror <br>
            </div>

            <div class="mb-3">
                <label for="authors" class="block font-medium text-sm text-gray-700 mb-2">Authors: </label>
                <input
                    class="form-control border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block w-full"
                    type="text"
                    name="authors"
                    value="{{ old('authors', $song?->authors) }}">
                @error('authors')
                <span class="fw-bold">{{ $errors->first('authors') }}</span>
                @enderror <br>
            </div>

            <div class="mb-3">
                @php
                    $data['name'] = "genre";
                    $data['options'] = \App\Enums\GenresEnum::getAllGenres();
                    $data['selectedData'] = old('genre', $song?->genres->pluck('name')->toArray());
                    $data['errors'] = $errors;
                @endphp
                <x-checkboxes :data="$data"/>
            </div>

            <input
                class="inline-flex items-center px-4 py-2 bg-green-500 border
                        border-transparent rounded-md text-xs text-white
                        tracking-widest hover:bg-green-700 focus:bg-green-700 active:bg-green-900
                        focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2
                        transition ease-in-out duration-150 ml-4 text-decoration-none uppercase"
                type="submit"
                value="{{ isset($song->id) ? 'Edit song' : 'Add song' }}">
        </form>
    </div>
@endsection
