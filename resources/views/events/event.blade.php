@props(['event'])

<div>
    <article>
        {{ "Event name: " . $event->name }} <br>

        {{ "Event address: " . $event->address  }}<br>

        {{ "Event date: " . $event->date }} <br>

        {{ "Event time: " . $event->time }} <br>

        {{ "Event description: " . $event->description }} <br>

        {{ "Event ticket price: " . $event->ticketPrice }} <br>

        {{ "Event musicians: " }} <br>

        @foreach($event->musicians as $musician)
            <label for="">{{ $musician->name }}</label><br>
        @endforeach
        <hr>

        @php
            $data['name'] = 'event';
            $data['id'] = $event->id;
        @endphp

        <x-buttons :data="$data" />
    </article>
</div>

