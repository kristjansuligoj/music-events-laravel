<?php

namespace App\Http\Controllers;

use App\Http\Requests\EventRequest;
use App\Models\Event;
use App\Models\Musician;

class EventController extends Controller
{
    public function allEvents(EventRequest $request) {
        return view('events/events',[
            'events' => $this->getOrderedEvents($request->order, $request->field)
        ]);
    }

    public function addEventForm() {
        return view('events/event-add', [
            'event' => null,
            'musicians' => Musician::all(),
        ]);
    }

    public function getEvent($id) {
        return view('events/event',[
            'event' => Event::with('musicians')->findOrFail($id)
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

        return redirect()->route('events.list');
    }

    public function editEvent($id, EventRequest $request) {
        $eventData = $request->except(['_token', "_method"]);

        $event = Event::findOrFail($id);
        $event->update($eventData);

        $event->musicians()->sync($request->musician);

        return redirect()->route('events.list');
    }

    public function deleteEvent($id) {
        $event = Event::findOrFail($id);
        $event->delete();

        return redirect()->route('events.list');
    }

    public function getOrderedEvents($sortOrder, $sortField) {
        if ($sortOrder === null) {
            return Event::paginate(7);;
        } else {
            if ($sortField === "musician") {
                return Event::join('events_musicians', 'events.id', '=', 'events_musicians.event_id')
                    ->join('musicians', 'events_musicians.musician_id', '=', 'musicians.id')
                    ->orderBy('musicians.name', $sortOrder)
                    ->select('events.*')
                    ->paginate(7);
            } else {
                return Event::orderBy($sortField, $sortOrder)->paginate(7);
            }
        }
    }
}
