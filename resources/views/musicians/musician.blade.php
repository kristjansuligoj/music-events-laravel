@extends('layout.main')
@section('page-content')
    @props(["musician"])
    <div class="container">
        @php
            $data['name'] = 'musician';
            $data['id'] = $musician->id;
        @endphp
        <x-buttons :data="$data"/>
        <hr>

        <div class="container">
            <div class="d-flex align-items-center">
                <img
                    class="m-2"
                    src="{{ asset('images/' .  $musician->image) }}"
                    style="width: 50px; height:50px; border-radius: 30%">
                <b>{{ $musician?->name }}</b>
            </div>
            <hr>

            <b>Genre:</b><br>
            <?php echo printArray($musician->genres, "name"); ?>
        </div>
    </div>
@endsection


