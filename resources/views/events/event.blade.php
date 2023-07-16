<a href="/events">Back</a><br>

<body>
    <article>
        <?php echo "Event name: " . $event->name; ?> <br>

        <?php echo "Event address: " . $event->address; ?> <br>

        <?php echo "Event date: " . $event->date; ?> <br>

        <?php echo "Event time: " . $event->time; ?> <br>

        <?php echo "Event description: " . $event->description; ?> <br>

        <?php echo "Event ticketPrice: " . $event->ticketPrice; ?> <br>

        <hr>
        <form method="post" action="/events/remove/<?php echo $event->uuid; ?>">
            @csrf
            @method('DELETE')

            <input type="submit" value="Remove event">
        </form>

        <a href="/events/edit/<?php echo $event->uuid; ?>">Edit event</a>
        <hr>
    </article>
</body>

