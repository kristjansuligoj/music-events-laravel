<a href="/">Back</a><br>

<body>
    <b>Image: </b><img src="{{ asset('images/' .  $musician->image) }}" width="300px" height="300px"><br>
    <b>Name: </b>{{ $musician?->name }} <br>

    <b>Genre:</b><br>
    <?php echo printArray($musician->genres, "name") ?>

    <hr>
    <form method="post" action="/musicians/remove/{{ $musician->id }}">
        @csrf
        @method('DELETE')

        <input type="submit" value="Remove musician">
    </form>

    <a href="/musicians/edit/{{ $musician->id }}">Edit musician</a>

    <hr>

</body>


