@extends('layout.main')
@section('page-content')
    <div class="container">
        <hr>
        <div class="d-flex justify-content-between align-items-baseline">
            <h4>List of musicians:</h4>
            <a
                class="btn btn-success"
                href="{{ route('musicians.add') }}"
                style="width:200px"
            >Add musician</a>
        </div>
        <hr>
        @foreach($musicians as $musician)
            <article class="p-2 border mt-5 d-flex justify-content-between align-items-center"
                     style="background-color: #F2F1F1">
                <h5>{{ $musician->name }}</h5>
                <a
                    class="btn btn-outline-danger btn-sm m-2"
                    href="/musicians/{{ $musician->id }}"
                >More details!</a>
            </article>
        @endforeach
    </div>
@endsection
