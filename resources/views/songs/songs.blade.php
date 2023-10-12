@extends('layout.main')
@section('page-content')
    <div class="container p-5 sm:p-8 bg-white shadow sm:rounded-lg">
        <div>
            @php
                $data['currentOrder'] = request()->input('order', '');
                $data['nextOrder'] = ( $data['currentOrder'] === 'asc') ? 'desc' : (( $data['currentOrder'] === 'desc') ? '' : 'asc');
                $data['route'] = "songs.list";
                $data['fields'] = ['title', 'genre', 'length', 'releaseDate', 'authors', 'musician'];
            @endphp
            <div class="mb-3">
                <x-filter :data="$data"/>
                <x-searchbar/>
            </div>
        </div>
        <div class="d-flex justify-content-between align-items-baseline mt-5">
            <h4>Songs:</h4>

            <x-button :route="'songs.add'" :buttonText="'Add song'"/>
        </div>
        @foreach($songs as $song)
            <article class="p-3 border mt-5 justify-content-between align-items-center sm:p-8 bg-gray-100 shadow sm:rounded-lg"
                     style="background-color: #F2F1F1">
                <div class="d-flex justify-content-between">
                    {{ $song->title }} <br>

                    <x-button :href="'/songs/' . $song->id" :buttonText="'More details!'"/>
                </div>
            </article>
        @endforeach
        <div class="d-flex justify-content-center m-5">
            @if($songs instanceof \Illuminate\Pagination\LengthAwarePaginator)
                {{$songs->links()}}
            @endif
        </div>
    </div>
@endsection
