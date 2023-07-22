@props(["musician"])

<div>
    <b>Image: </b><br><img src="{{ asset('images/' .  $musician->image) }}" width="300px" height="300px"><br>
    <b>Name: </b><br>{{ $musician?->name }} <br>

    <b>Genre:</b><br>
    <?php echo printArray($musician->genres, "name"); ?>

    <hr>
    @php
        $data['name'] = 'musician';
        $data['id'] = $musician->id;
    @endphp

    <x-buttons :data="$data" />
</div>


