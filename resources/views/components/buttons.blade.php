@props(['element'])

<form method="post" action="/{{$element['name']}}s/remove/<?php echo $element['id']; ?>">
    @csrf
    @method('DELETE')

    <input type="submit" value="Remove {{$element['name']}}">
</form>

<a href="/{{$element['name']}}s/edit/<?php echo $element['id']; ?>">Edit {{$element['name']}}</a>
<hr>
