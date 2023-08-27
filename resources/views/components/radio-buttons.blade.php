@props(['data'])

<div>
    <label for="{{$data['name']}}">{{ucfirst($data['name'])}}: </label><br>
    @foreach($data['options'] as $option)
        <input type="radio" id="{{substr($data['name'], 0, -1)}}{{$loop->iteration}}" name="{{substr($data['name'], 0, -1)}}" value="{{$option->id}}"
            @if(isset($data['selectedData']) && $data['selectedData']->contains('id', $option->id)) checked @endif
        >

        <label for="{{$option->name}}">{{ $option->name }}</label><br>
    @endforeach
    @error($data['name'])
        <span class="fw-bold">{{ $errors->first(substr($data['name'], 0, -1)) }}</span>
    @enderror
</div><hr>
