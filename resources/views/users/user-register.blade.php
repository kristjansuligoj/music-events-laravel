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
                <label for="username">Name: </label><br>
                <input type="text"
                       name="name"
                       required
                       value="{{ old('name', '') }}"
                /><br>
                @error('name')
                <span class="fw-bold">{{ $errors->first('name') }}</span>
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

            <div class="mb-3">
                <label for="username">Confirmation password: </label><br>
                <input type="password"
                       name="password_confirmation"
                       required
                /><br>
                @error('password_confirmation')
                <span class="fw-bold">{{ $errors->first('password_confirmation') }}</span>
                @enderror
            </div>

            <input class="btn btn-success"
                   type="submit"
                   value="Register"
            />
        </form>
    </div>
@endsection
