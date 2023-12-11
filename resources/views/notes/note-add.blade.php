@extends('layout.main')
@section('page-content')
    <div class="container w-full sm:max-w-md mt-6 p-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
        <x-button :href="url('/notes')" :buttonText="'Back'"/>

        <h6 class="mt-3">Fields that have * are required!</h6>

        <form method="post" class="mt-4">
            @csrf <!-- Validates the request for cross-site request forgery (session token) -->
            @isset($note->id)
                @method('PATCH')
                <input hidden name="id" value="{{ old('id', $note?->id)}}">
            @endisset

            <input hidden name="user_id" value="{{ session('user_id') }}">
            <input hidden name="category_id" value="9ad11014-626e-4858-b926-2281005dab76">
            <input hidden name="public" value="1">

            <div class="mb-3">
                <label for="title" class="block font-medium text-sm text-gray-700 mb-2">* Title: </label>
                <input
                    class="form-control border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block w-full"
                    required
                    type="text"
                    name="title"
                    value="{{ old('title', $note?->title) }}">
                @error('title')
                <span class="fw-bold text-red-500">{{ $errors->first('title') }}</span>
                @enderror <br>
            </div>

            <div class="mb-3">
                <label for="noteContent" class="block font-medium text-sm text-gray-700 mb-2">* Content: </label>
                <input
                    class="form-control border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block w-full"
                    type="text"
                    name="noteContent"
                    value="{{ old('noteContent', $note?->content) }}">
                @error('noteContent')
                <span class="fw-bold text-red-500">{{ $errors->first('noteContent') }}</span>
                @enderror <br>
            </div>

            <div class="mb-3">
                <label for="priority" class="block font-medium text-sm text-gray-700 mb-2">* Priority: </label>
                <input
                    class="form-control border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block w-full"
                    type="number"
                    min="1"
                    max="5"
                    name="priority"
                    value="{{ old('priority', $note?->priority) }}">
                @error('priority')
                <span class="fw-bold text-red-500">{{ $errors->first('priority') }}</span>
                @enderror <br>
            </div>

            <div class="mb-3">
                <label for="deadline" class="block font-medium text-sm text-gray-700 mb-2">* Deadline: </label>
                <input
                    class="form-control border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block w-full"
                    type="date"
                    name="deadline"
                    value="{{ old('deadline', $note?->deadline) }}">
                @error('deadline')
                <span class="fw-bold text-red-500">{{ $errors->first('deadline') }}</span>
                @enderror <br>
            </div>

            <div class="mb-3">
                <label for="tags" class="block font-medium text-sm text-gray-700 mb-2">* Tags: </label>
                <input
                    class="form-control border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block w-full"
                    type="text"
                    name="tags"
                    value="{{ old('tags', $note?->tags) }}">
                @error('tags')
                <span class="fw-bold text-red-500">{{ $errors->first('tags') }}</span>
                @enderror <br>
            </div>

            <div class="mb-3">
                <label for="public" class="block font-medium text-sm text-gray-700 mb-2">* Public: </label>

                <label>
                    <input
                        type="radio"
                        name="public"
                        value="1"
                        @if(!isset($note->public) || isset($note->public) && $note->public)
                            checked
                        @endif
                    >
                    Public
                </label><br>

                <label>
                    <input
                        type="radio"
                        name="public"
                        value="0"
                        @if(isset($note->public) && !$note->public)
                            checked
                        @endif
                    >
                    Private
                </label>

                @error('public')
                <span class="fw-bold text-red-500">{{ $errors->first('public') }}</span>
                @enderror <br>
            </div>

            <div class="mb-3">
                <label for="category" class="block font-medium text-sm text-gray-700 mb-2">* Category: </label>
                <div>
                    <select class="form-control w-100" name="category">
                        @foreach($categories['categories'] as $category)
                            <option
                                id="{{ $category['id'] }}"
                                name="category"
                                value="{{ $category['id'] }}"
                                @if(old('category', $note?->category_id) !== null && old('category', $note?->category_id) === $category['id'])
                                    selected
                                @endif
                            >
                                {{ $category['title'] }}
                            </option>
                        @endforeach
                    </select>
                    @error('category_id')
                    <span class="fw-bold text-red-500">{{ $errors->first('category_id') }}</span>
                    @enderror
                </div>

                @push('scripts')
                    <script type="text/javascript">
                        $(document).ready(function () {
                            $('#category').select2();
                        });
                    </script>
                @endpush
            </div>

            <input
                class="inline-flex items-center px-4 py-2 bg-green-500 border
                        border-transparent rounded-md text-xs text-white
                        tracking-widest hover:bg-green-700 focus:bg-green-700 active:bg-green-900
                        focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2
                        transition ease-in-out duration-150 ml-4 text-decoration-none uppercase"
                type="submit"
                value="{{ isset($note->id) ? 'Edit note' : 'Add note' }}">
        </form>
    </div>
@endsection
