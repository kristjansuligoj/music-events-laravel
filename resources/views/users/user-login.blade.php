@extends('layout.main')
@section('page-content')
    <div class="container">
        <a
            class="btn btn-outline-dark mb-3"
            href="{{ url('/') }}"
        >Back</a><br>
        <hr>

        <form method="post">
            @csrf <!-- Validates the request for cross-site request forgery (session token) -->

            <div class="mb-3">
                <label for="username">Username: </label><br>
                <input type="text"
                       name="username"
                       required
                       value="{{ old('username', '') }}"
                /><br>
                @error('username')
                <span class="fw-bold">{{ $errors->first('username') }}</span>
                @enderror
            </div>

            <div class="mb-3">
                <label for="username">Password: </label><br>
                <input type="password"
                       name="password"
                       required
                /><br>
                @error('password')
                <span class="fw-bold">{{ $errors->first('password') }}</span>
                @enderror
            </div>

            <input class="btn btn-success"
                   type="submit"
                   value="Login"
            />
        </form>
    </div>
@endsection
