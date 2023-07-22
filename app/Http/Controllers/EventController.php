<?php

namespace App\Http\Controllers;

use App\Http\Requests\EventRequest;
use App\Models\Event;
use App\Models\Musician;

class EventController extends Controller
{
    public function allEvents() {
        return view('events/events',[
            'events' => Event::all()
        ]);
    }

    public function addEventForm() {
        return view('events/event-add', [
            'event' => null,
            'musicians' => Musician::all(),
        ]);
    }

    public function getEvent($id) {
        return view('components/display',[
            'component' => "event",
            'data' => Event::with('musicians')->findOrFail($id)
        ]);
    }

    public function editEventForm($id) {
        return view('events/event-add', [
            'event' => Event::with('musicians')->findOrFail($id),
            'musicians' => Musician::all(),
        ]);
    }

    public function addEvent(EventRequest $request) {
        $eventData = $request->all();
        $event = Event::create($eventData);

        // Adds genres to the pivot table
        $event->musicians()->sync($eventData['musician']);

        return redirect('/events');
    }

    public function editEvent($id, EventRequest $request) {
        $requestData = $request->except(['_token', "_method"]);

        $event = Event::findOrFail($id);
        $event->update($requestData);

        $event->musicians()->sync($request->musician);

        return redirect('/events');
    }

    public function deleteEvent($id) {
        $event = Event::findOrFail($id);
        $event->delete();

        return redirect('/events');
    }
}
