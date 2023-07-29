@extends('layout.main')
@section('page-content')
    <div class="container">
        <a
            class="btn btn-outline-dark mb-3"
            href="{{ $musician ? url('musicians/' . $musician->id) : url('musicians') }}"
        >Back</a><br>
        <hr>

        <form method="post" enctype="multipart/form-data">
            @csrf <!-- Validates the request for cross-site request forgery (session token) -->
            @isset($musician['id'])
                @method('PATCH')
            @endisset

            <div class="mb-3">
                <label for="image">Image </label><br>
                <input
                    class="form-control"
                    type="file"
                    name="image"
                    required/><br>
            </div>


            <div class="mb-3">
                <label for="name">Name </label><br>
                <input
                    class="w-100"
                    required
                    type="text"
                    name="name"
                    value="{{ old('name', $musician?->name) }}">
                @error('name')
                <span>{{ $errors->first('name') }}</span>
                @enderror
                <br>
            </div>

            <div class="mb-3">
                @php
                    $data['name'] = "genre";
                    $data['options'] = \App\Enums\GenresEnum::getAllGenres();
                    $data['selectedData'] = isset($musician->genres) ? $musician->genres : null;
                    $data['errors'] = $errors;
                @endphp
                <x-checkboxes :data="$data"/>
            </div>

            <input
                class="btn btn-success"
                type="submit"
                value="{{ isset($musician->id) ? 'Edit musician' : 'Add musician' }}"
            >
        </form>
    </div>
@endsection
