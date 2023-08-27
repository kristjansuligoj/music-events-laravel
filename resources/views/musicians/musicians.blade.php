@extends('layout.main')
@section('page-content')
    <div class="container">
        <div>
            @php
                $data['currentOrder'] = request()->input('order', '');
                $data['nextOrder'] = ( $data['currentOrder'] === 'asc') ? 'desc' : (( $data['currentOrder'] === 'desc') ? '' : 'asc');
                $data['route'] = "musicians.list";
                $data['fields'] = ['name', 'genre'];
            @endphp
            <div class="mb-3">
                <x-filter :data="$data"/>
                <x-searchbar/>
            </div>
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
            <article class="p-2 border mt-5 justify-content-between align-items-center"
                     style="background-color: #F2F1F1">

                <div class="d-flex justify-content-between">
                    <h5>{{ $musician->name }}</h5>
                    <a
                        class="btn btn-outline-danger btn-sm m-2"
                        href="/musicians/{{ $musician->id }}"
                    >More details!</a>
                </div>

                @php
                    $data['elements'] = $musician->songs;
                    $data['property'] = "title";
                    $data['text'] = "This musician has written the following song";
                @endphp
                <div class="mb-3">
                    <x-relations-list :data="$data"/>
                </div>

                @php
                    $data['elements'] = $musician->events;
                    $data['property'] = "name";
                    $data['text'] = "This musician is performing in the following event";
                @endphp
                <div class="mb-3">
                    <x-relations-list :data="$data"/>
                </div>
            </article>
            <hr>
        @endforeach
        <div class="d-flex justify-content-center m-5">
            @if($musicians instanceof \Illuminate\Pagination\LengthAwarePaginator)
                {{$musicians->links()}}
            @endif
        </div>
    </div>
@endsection
