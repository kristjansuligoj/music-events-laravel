<a href="/">Back</a><br>

<h1>Musicians page</h1>
<h3><a href="/musicians/add">Add musician</a></h3>

<div>
    @foreach($musicians as $musician)
        <article>
            <b>Musician name: {{ $musician->name }}</b><br>
            <a href="/musicians/{{ $musician->id }}">Click to see more details!</a>
        </article>
        <hr>
    @endforeach
</div>
