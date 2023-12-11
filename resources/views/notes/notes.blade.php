@extends('layout.main')
@section('page-content')
    <div class="container p-5 sm:p-8 bg-white shadow sm:rounded-lg">
        <div class="d-flex justify-content-between align-items-baseline">
            <x-button :route="'notes.add'" :buttonText="'Add note'"/>
        </div>
        <br>

        @if ($notes && !empty($notes['notes']))
            <hr>
            <h4>Your notes:</h4>

            <table class="">
                <thead>
                <tr>
                    <th>Title</th>
                    <th>Content</th>
                    <th>Priority</th>
                    <th>Deadline</th>
                    <th>Tags</th>
                    <th>Public</th>
                </tr>
                </thead>

                <tbody>
                @foreach($notes['notes'] as $note)
                    <tr>
                        <td>{{ $note['title'] }}</td>
                        <td>{{ $note['content'] }}</td>
                        <td>{{ $note['priority'] }}</td>
                        <td>{{ $note['deadline'] }}</td>
                        <td>{{ $note['tags'] }}</td>
                        <td>{{ $note['public'] ? 'Yes' : 'No' }}</td>

                        <td>
                            <div class="d-flex justify-content-around m-5">
                                <a
                                    class="inline-flex items-center px-4 py-2 bg-green-500 border
                                    border-transparent rounded-md text-xs text-white
                                    tracking-widest hover:bg-green-700 focus:bg-green-700 active:bg-green-900
                                    focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2
                                    transition ease-in-out duration-150 ml-4 text-decoration-none uppercase h-100"
                                    href="/notes/edit/{{ $note['id'] }}"
                                >Edit note</a>

                                <form method="post" action="/notes/remove/{{ $note['id'] }}">
                                    @csrf
                                    @method('DELETE')
                                    <input
                                        onclick="return confirm('Are you sure?')"
                                        class="inline-flex items-center px-4 py-2 bg-red-800 border
                                        border-transparent rounded-md text-xs text-white
                                        tracking-widest hover:bg-red-700 focus:bg-red-700 active:bg-red-900
                                        focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2
                                        transition ease-in-out duration-150 ml-4 text-decoration-none uppercase h-100"
                                        type="submit"
                                        value="Remove note"
                                    >
                                </form>
                            </div>
                        </td>
                    </tr>

                @endforeach
                </tbody>
            </table>
        @else
            <h3>No notes yet</h3>
        @endif
    </div>
@endsection
