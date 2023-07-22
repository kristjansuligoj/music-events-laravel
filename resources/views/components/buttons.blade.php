@props(['data'])

<div>
    <form method="post" action="/{{ $data['name'] }}s/remove/{{ $data['id'] }}">
        @csrf
        @method('DELETE')

        <input type="submit" value="Remove {{ $data['name'] }}">
    </form>

    <a href="/{{ $data['name'] }}s/edit/{{ $data['id'] }}">Edit {{ $data['name'] }}</a>
    <hr>
</div>
