@props(['event'])

<body>
    <article>
         {{ "Event name: " . $event['name'] }} <br>

         {{ "Event address: " . $event['address']  }}<br>

         {{ "Event date: " . $event['date'] }} <br>

         {{ "Event time: " . $event['time'] }} <br>

         {{ "Event description: " . $event['description'] }} <br>

         {{ "Event ticket price: " . $event['ticketPrice'] }} <br>

         {{ "Event musicians: " }} <br>

         <?php foreach($event['musicians'] as $musician): ?>
             <label for=""><?php echo $musician['name']; ?></label><br>
         <?php endforeach; ?>

         <hr>
        @php
            $element = [
                'name' => 'event',
                'id' => $event->id,
            ];
        @endphp

        <x-buttons :element="$element" />
    </article>
</body>

