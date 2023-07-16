<a href="/">Back</a><br>

<body>
    <b>Name: </b><?php echo $musician?->name ?><br>

    <b>Genre:</b><br>
    <?php echo printArray($musician->genres, "name"); ?>

    <hr>
    <form method="post" action="/musicians/remove/<?php echo $musician->id; ?>">
        @csrf
        @method('DELETE')

        <input type="submit" value="Remove musician">
    </form>

    <a href="/musicians/edit/<?php echo $musician->id; ?>">Edit musician</a>

    <hr>

</body>


