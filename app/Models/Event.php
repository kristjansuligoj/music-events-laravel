<?php

namespace App\Models;

class Event extends Model
{
    public string $name;

    public string $address;

    public string $date;

    public string $time;

    public string $description;

    public int $ticketPrice;

    public static function createFromArray(array $data): Event {
        $event = new Event();
        $event->name = $data['name'];
        $event->address = $data['address'];
        $event->date = $data['date'];
        $event->time = $data['time'];
        $event->description = $data['description'];
        $event->ticketPrice = $data['ticketPrice'];

        return $event;
    }
}
