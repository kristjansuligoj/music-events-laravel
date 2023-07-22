<a href="/">Back</a><br>
<h3><a href="/songs/add">Add song</a></h3>

<div>
    @foreach($songs as $song)
        <article>
            {{ "Song name: " . $song->title }} <br>
            <a href="/songs/{{$song->id}}">Click to see more details!</a>
        </article>
        <hr>
    @endforeach
</div>
