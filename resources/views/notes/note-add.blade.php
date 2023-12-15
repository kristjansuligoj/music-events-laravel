@extends('layout.main')
@section('page-content')
    <div class="container w-full sm:max-w-md mt-6 p-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
        <x-button :href="url('/notes')" :buttonText="'Back'"/>

        <h6 class="mt-3">Fields that have * are required!</h6>

        <form method="post" class="mt-4" action="{{ isset($note->id) ? route('notes.edit', $note->id) : route('notes.add') }}">
            @csrf <!-- Validates the request for cross-site request forgery (session token) -->
            @isset($note->id)
                @method('PATCH')
            @endisset

            <div class="mb-3">
                <x-input-label for="title">* Title:</x-input-label>
                <x-text-input
                    class="form-control border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block w-full"
                    required
                    type="text"
                    name="title"
                    value="{{ old('title', $note?->title) }}"/>
                @error('title')
                    <x-input-error :messages="$errors->first('title')" class="mt-2"/>
                @enderror <br>
            </div>

            <div class="mb-3">
                <x-input-label for="noteContent">* Content: </x-input-label>
                <x-text-input
                    class="form-control border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block w-full"
                    type="text"
                    name="noteContent"
                    value="{{ old('noteContent', $note?->content) }}"/>
                @error('noteContent')
                    <x-input-error :messages="$errors->first('noteContent')" class="mt-2"/>
                @enderror <br>
            </div>

            <div class="mb-3">
                <x-input-label for="priority">* Priority: </x-input-label>
                <x-text-input
                    class="form-control border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block w-full"
                    type="number"
                    min="1"
                    max="5"
                    name="priority"
                    value="{{ old('priority', $note?->priority) }}"/>
                @error('priority')
                    <x-input-error :messages="$errors->first('priority')" class="mt-2"/>
                @enderror <br>
            </div>

            <div class="mb-3">
                <x-input-label for="deadline">* Deadline: </x-input-label>
                <input
                    class="form-control border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block w-full"
                    type="date"
                    name="deadline"
                    value="{{ old('deadline', $note?->deadline) }}"/>
                @error('deadline')
                    <x-input-error :messages="$errors->first('deadline')" class="mt-2"/>
                @enderror <br>
            </div>

            <div class="mb-3">
                <x-input-label for="tags">* Tags: </x-input-label>
                <x-text-input
                    class="form-control border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block w-full"
                    type="text"
                    name="tags"
                    value="{{ old('tags', $note?->tags) }}"/>
                @error('tags')
                    <x-input-error :messages="$errors->first('tags')" class="mt-2"/>
                @enderror <br>
            </div>

            <div class="mb-3">
                <x-input-label for="public">* Public: </x-input-label>

                <label>
                    <input
                        type="radio"
                        name="public"
                        value="1"
                        @checked(old('public', $note?->public) == 1)
                    />
                    Public
                </label><br>

                <label>
                    <input
                        type="radio"
                        name="public"
                        value="0"
                        @checked(old('public', $note?->public) == 0)
                    />
                    Private
                </label><br>

                @error('public')
                    <x-input-error :messages="$errors->first('public')" class="mt-2"/>
                @enderror
            </div>

            <div class="mb-3">
                <x-input-label for="category">* Category: </x-input-label>
                <div>
                    <select class="form-control w-100" name="category_id">
                        @foreach($categories['categories'] as $category)
                            <option
                                id="{{ $category['id'] }}"
                                name="category_id"
                                value="{{ $category['id'] }}"
                                @selected(old('category_id', $note?->category_id) === $category['id'])
                            >
                                {{ $category['title'] }}
                            </option>
                        @endforeach
                    </select>
                    @error('category_id')
                        <x-input-error :messages="$errors->first('category_id')" class="mt-2"/>
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
