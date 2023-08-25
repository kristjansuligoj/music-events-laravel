@props(['data'])

Sort by:
@foreach($data['fields'] as $field)
    <th>
        <a href="{{ route($data['route'], ['order' => $data['nextOrder'], 'field' => $field]) }}">{{ucfirst($field)}}</a>
    </th>
@endforeach
<br>
Order: {{ $data['currentOrder'] }}
