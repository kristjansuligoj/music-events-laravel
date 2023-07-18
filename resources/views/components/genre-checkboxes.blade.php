@php
$validGenres = ["Rock", "Metal", "Rap", "Country", "Hip hop", "Jazz", "Electronic"];
$count = 1;
@endphp

@props(['data'])

<div>
    <label for="genre">Genre: </label><br>
    @foreach($validGenres as $genre)
        <input type="checkbox" id="genre{{$count}}" name="genre[]" value="{{$genre}}"
           @if(isset($data['genres']) && in_array($genre, $data['genres']))
               checked
            @endif
        ><label for="genre{{$count}}">{{$genre}}</label><br>
        @php $count++ @endphp
    @endforeach
</div>
@php if (isset($data)) displayErrorIfExists($data['errors'], "genre") @endphp <hr>
