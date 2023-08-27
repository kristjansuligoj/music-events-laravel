@props(['data'])

<div>
    @if(count($data['elements']) > 0)
        <span>
            {{ count($data['elements']) === 1 ? ($data['text'] . ":") : ($data['text'] . "s:")  }}
        </span> <br>

        <ul>
            @foreach($data['elements'] as $element)
                <li>{{ $element[$data['property']]}}</li>
            @endforeach
        </ul>
    @endif
</div>
