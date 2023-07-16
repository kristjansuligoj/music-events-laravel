<a href="/">Back</a><br>
<h3><a href="/events/add">Add event</a></h3>

<body>
    <?php foreach($events as $event): ?>
        <article>
            <?php echo "Event name: " . $event->name; ?> <br>
            <?php echo "Event date: " . $event->date; ?> <br>
            <?php echo "Event time: " . $event->time; ?> <br>
            <a href="/events/<?php echo $event->uuid; ?>">Click to see more details!</a>
        </article>
        <hr>
    <?php endforeach; ?>
</body>

