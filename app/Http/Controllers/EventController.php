<?php

namespace App\Http\Controllers;

use App\Models\Musician;
use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function allEvents() {
        $event = new Event();

        return view('events/events',[
            'events' => $event->all()
        ]);
    }

    public function addEventForm() {
        return view('events/event-add');
    }

    public function getEvent($id) {
        $event = new Event();

        return view('events/event',[
            'event' => $event->find($id)
        ]);
    }

    public function editEventForm($id) {
        $event = new Event();
        $musicians = new Musician();

        return view('events/event-edit', [
            'event' => $event->find($id),
            'musicians' => $musicians->all(),
        ]);
    }

    public function addEvent(Request $request) {
        $event = Event::createFromArray($request->all());
        $event->add();

        return redirect('/events');
    }

    public function editEvent($id, Request $request) {
        $event = Event::createFromArray($request->all());
        $event->uuid = $id;
        $event->edit();

        return redirect('/events');
    }

    public function deleteEvent($id) {
        $event = new Event();
        $event->remove($id);

        return redirect('/events');
    }
}
