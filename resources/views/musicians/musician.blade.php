<a href="/">Back</a><br>

<body>
    <b>Image: </b><img src="{{ asset('images/' .  $musician->image) }}" width="300px" height="300px"><br>
    <b>Name: </b>{{ $musician?->name }} <br>

    <b>Genre:</b><br>
    <?php echo printArray($musician->genres, "name") ?>

    <hr>
    @php
        $element = [
            'name' => 'musician',
            'id' => $musician->id,
        ];
    @endphp

    <x-buttons :element="$element" />
</body>


