@extends('layout.main')
@section('page-content')
    <div class="container">
        <div>
            @php
                $currentOrder = request()->input('order', '');
                $nextOrder = ($currentOrder === 'asc') ? 'desc' : (($currentOrder === 'desc') ? '' : 'asc');
            @endphp
            Sort by:
            <th>
                <a href="{{ route('musicians.list', ['order' => $nextOrder, 'field' => 'name']) }}">Name</a>
            </th>
            <th>
                <a href="{{ route('musicians.list', ['order' => $nextOrder, 'field' => 'genre']) }}">Genre</a>
            </th><br>
            Order: {{ $currentOrder }}
            <form action="">
                <input type="text" placeholder="Search by keyword . . .">
                <input type="submit" value="Search">
            </form>
        </div>
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
        <div class="d-flex justify-content-center m-5">
            @if($musicians instanceof \Illuminate\Pagination\LengthAwarePaginator)
                {{$musicians->links()}}
            @endif
        </div>
    </div>
@endsection
