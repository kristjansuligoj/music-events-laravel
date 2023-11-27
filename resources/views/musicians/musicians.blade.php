@extends('layout.main')
@section('page-content')
    <div class="container p-5 sm:p-8 bg-white shadow sm:rounded-lg">
        <div>
            @php
                $data['currentOrder'] = request()->input('order', '');
                $data['sortOrder'] = $sortOrder;
                $data['route'] = "musicians.list";
                $data['fields'] = array_keys($sortOrder);
            @endphp
            <div class="mb-3">
                <x-filter :data="$data"/>
                <x-searchbar/>
            </div>
        </div>
        <div class="d-flex justify-content-between align-items-baseline mt-5">
            <h4>Musicians:</h4>

            @if(Auth::check())
                <x-button :route="'musicians.add'" :buttonText="'Add musician'"/>
            @endif
        </div>
        @foreach($musicians as $musician)
            <article class="p-3 border mt-5 justify-content-between align-items-center sm:p-8 bg-gray-100 shadow sm:rounded-lg"
                     style="background-color: #F2F1F1">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center">
                        <img class="m-2" src="{{ asset('images/musicians/' .  $musician->image) }}" style="width: 50px; height:50px; border-radius: 30%">
                        <h5>{{ $musician->name }}</h5>
                    </div>
                    <x-button :href="'/musicians/' . $musician->id" :buttonText="'More details!'"/>
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
        @endforeach
        <div class="d-flex justify-content-center m-5">
            @if($musicians instanceof \Illuminate\Pagination\LengthAwarePaginator)
                {{$musicians->links()}}
            @endif
        </div>
    </div>
@endsection
