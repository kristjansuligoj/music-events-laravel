@props(['data'])

Sort by:
@foreach($data['fields'] as $field)
    <th>
        <a href="{{ route($data['route'], array_merge(['order' => $data['sortOrder'][$field], 'field' => $field,], request('showAttending') ? ['showAttending' => true] : [])) }}">{{ucfirst($field)}}</a>
    </th>
@endforeach
<br>
Order: {{ $data['currentOrder'] }}
