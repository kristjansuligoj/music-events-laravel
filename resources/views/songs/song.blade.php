<a href="/">Back</a><br>

<h3>Songs page</h3>

<body>
    <article>
        <?php echo "<b>Name:</b> " . $song->title; ?> <br>

        <b>Genre:</b><br>
        <?php echo printArray($song->genres, "name"); ?>

        <?php echo "<b>Length:</b> " . $song->length; ?> <br>

        <?php echo "<b>Release date:</b> " . $song->releaseDate; ?> <br>

        <b>Authors:</b><br>
        <?php echo printArray($song->authors, "name"); ?>

        <?php echo "<b>Musician:</b> " . $song->musician->name; ?> <br>

        <hr>
        <form method="post" action="/songs/remove/<?php echo $song->id; ?>">
            @csrf
            @method("DELETE")

            <input type="submit" value="Remove song">
        </form>

        <a href="/songs/edit/<?php echo $song->id; ?>">Edit song</a>

        <hr>
    </article>
</body>
