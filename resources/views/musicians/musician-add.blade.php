<a href="/musicians">Back</a><br>

<div>
    <form method="post" enctype="multipart/form-data">
        @csrf <!-- Validates the request for cross-site request forgery (session token) -->
        @isset($musician['id'])
            @method('PATCH')
        @endisset

        <input type="file" class="form-control" name="image" required/><br>

        <label for="name">Name: </label><br>
        <input required type="text" name="name" value="{{ old('name', $musician?->name) }}">
        @error('name')
            <span>{{ $errors->first('name') }}</span>
        @enderror
        <br>

        @php
            $data['name'] = "genre";
            $data['options'] = \App\Enums\GenresEnum::getAllGenres();
            $data['selectedData'] = isset($musician->genres) ? $musician->genres : null;
            $data['errors'] = $errors;
        @endphp
        <x-checkboxes :data="$data"/>

        <input type="submit" value="{{ isset($musician['id']) ? 'Edit musician' : 'Add musician' }}">
    </form>
</div>
