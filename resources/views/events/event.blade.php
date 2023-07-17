<a href="/events">Back</a><br>

<body>
    <article>
        <?php echo "Event name: " . $event->name; ?> <br>

        <?php echo "Event address: " . $event->address; ?> <br>

        <?php echo "Event date: " . $event->date; ?> <br>

        <?php echo "Event time: " . $event->time; ?> <br>

        <?php echo "Event description: " . $event->description; ?> <br>

        <?php echo "Event ticket price: " . $event->ticketPrice; ?> <br>

        <?php echo "Event musicians: " ?> <br>

        <?php foreach($event->musicians as $musician): ?>
            <label for=""><?php echo $musician->name; ?></label><br>
        <?php endforeach; ?>

        <hr>
        <form method="post" action="/events/remove/<?php echo $event->id; ?>">
            @csrf
            @method('DELETE')

            <input type="submit" value="Remove event">
        </form>

        <a href="/events/edit/<?php echo $event->id; ?>">Edit event</a>
        <hr>
    </article>
</body>

