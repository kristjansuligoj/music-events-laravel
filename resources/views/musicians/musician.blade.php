@extends('layout.main')
@section('page-content')
    @props(["musician"])
    <div class="container p-5 sm:p-8 bg-white shadow sm:rounded-lg">
        @if(Auth::check() && Auth::user()->id === $musician->user_id)
            @php
                $data['name'] = 'musician';
                $data['id'] = $musician->id;
                $data['usedElsewhere'] = $usedElsewhere;
                $data['musicianOwner'] = $musician->user_id;
                $data['loggedUser'] = Auth::user()->id;
            @endphp
            <x-buttons :data="$data"/>
            <hr>
        @endif

        <div class="container">
            <div>
                Added by user: <b>{{$musician->user->name}}</b>
            </div>
            <hr>

            <div class="d-flex align-items-center">
                <img
                    class="m-2"
                    src="{{ asset('images/musicians/' .  $musician->image) }}"
                    style="width: 50px; height:50px; border-radius: 30%">
                <b>{{ $musician?->name }}</b>
            </div>
            <hr>

            <b>Genre:</b><br>
            <?php echo printArray($musician->genres, "name"); ?>

            <hr>

            @php
                $data['elements'] = $musician->songs;
                $data['property'] = "title";
                $data['text'] = $musician->name . " has written the following song";
            @endphp
            <div class="mb-3">
                <x-relations-list :data="$data"/>
            </div>

            @php
                $data['elements'] = $musician->events;
                $data['property'] = "name";
                $data['text'] = $musician->name . " is performing in the following event";
            @endphp
            <div class="mb-3">
                <x-relations-list :data="$data"/>
            </div>
        </div>
    </div>
@endsection


