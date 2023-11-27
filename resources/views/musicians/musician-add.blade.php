@extends('layout.main')
@section('page-content')
    <div class="container w-full sm:max-w-md mt-6 p-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
        <x-button :href="$musician ? url('musicians/' . $musician->id) : url('musicians')" :buttonText="'Back'"/>

        <h6 class="mt-3">Fields that have * are required!</h6>

        <form method="post" enctype="multipart/form-data" class="mt-4">
            @csrf <!-- Validates the request for cross-site request forgery (session token) -->
            @isset($musician['id'])
                @method('PATCH')
            @endisset

            <div class="mb-3">
                <label for="image" class="block font-medium text-sm text-gray-700 mb-2">* Image </label>
                <input
                    class="form-control border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block w-full"
                    type="file"
                    name="image"
                    required/><br>
            </div>


            <div class="mb-3">
                <label for="name" class="block font-medium text-sm text-gray-700 mb-2">* Name </label>
                <input
                    class="form-control border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full"
                    required
                    type="text"
                    name="name"
                    value="{{ old('name', $musician?->name) }}">
                @error('name')
                <span class="fw-bold text-red-500">{{ $errors->first('name') }}</span>
                @enderror
                <br>
            </div>

            <div class="mb-3">
                @php
                    $data['name'] = "genre";
                    $data['options'] = \App\Enums\GenresEnum::getAllGenres();
                    $data['selectedData'] = old('genre', $musician?->genres->pluck('name')->toArray());
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
                value="{{ isset($musician->id) ? 'Edit musician' : 'Add musician' }}"
            >
        </form>
    </div>
@endsection
