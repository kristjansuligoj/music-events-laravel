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
        </div>
    </div>
@endsection


