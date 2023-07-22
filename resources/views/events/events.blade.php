<a href="/">Back</a><br>
<h3><a href="/events/add">Add event</a></h3>

<div>
    @foreach($events as $event)
        <article>
            {{ "Event name: " . $event->name }} <br>
            {{  "Event date: " . $event->date }} <br>
            {{  "Event time: " . $event->time }} <br>
            <a href="/events/{{  $event->id }}">Click to see more details!</a>
        </article>
        <hr>
    @endforeach
</div>

