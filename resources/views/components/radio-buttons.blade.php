@props(['data'])

@foreach($data as $entry)
    <input type="radio" name="musician" value="{{ $entry->id }}">
    <label for="">{{ $entry->name }}</label><br>
@endforeach <hr>
