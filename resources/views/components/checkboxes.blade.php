@props(['data'])

<div>
    <label for="{{$data['name']}}">{{ucfirst($data['name'])}}: </label><br>
    @foreach($data['options'] as $option)
        <input
            class="m-2"
            type="checkbox" id="{{$data['name']}}{{$loop->iteration}}" name="{{$data['name']}}[]" value="{{$option}}"
           @if(isset($data['selectedData']) && in_array($option, $data['selectedData']))
               checked
           @endif
        ><label for="{{$data['name']}}{{$loop->iteration}}">{{$option}}</label><br>
    @endforeach
</div>
@error($data['name'])
    <span class="fw-bold">{{ $errors->first($data['name']) }}</span>
@enderror
