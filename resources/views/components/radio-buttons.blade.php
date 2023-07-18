@props(['data'])

@foreach($data['musicians'] as $entry)
    <input type="radio" name="musician" value="{{ $entry->id }}"
        @if($entry->id == $data['selectedMusician']) checked @endif
    >

    <label for="">{{ $entry->name }}</label><br>
@endforeach <hr>
