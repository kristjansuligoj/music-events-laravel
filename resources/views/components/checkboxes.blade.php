@props(['data'])

<div>
    <label for="{{$data['name']}}">{{ucfirst($data['name'])}}: </label><br>
    @foreach($data['options'] as $option)
        <input
            class="m-2"
            type="checkbox" id="{{$data['name']}}{{$loop->iteration}}" name="{{$data['name']}}[]" value="{{$option}}"
           @if(isset($data['selectedData']) && $data['selectedData']->contains('name', $option))
               checked
           @endif
        ><label for="{{$data['name']}}{{$loop->iteration}}">{{$option}}</label><br>
    @endforeach
</div>
@error($data['name'])
    <span>{{ $errors->first($data['name']) }}</span>
@enderror
