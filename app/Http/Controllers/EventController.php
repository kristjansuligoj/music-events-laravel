<?php

namespace App\Http\Controllers;

use App\Models\CopyMusician;
use App\Models\Event;
use App\Models\EventCopy;
use App\Models\Song;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function allEvents() {
        return view('events/events',[
            'events' => Event::all()
        ]);
    }

    public function addEventForm() {
        return view('events/event-add');
    }

    public function getEvent($id) {
        return view('events/event',[
            'event' => Event::with('musicians')->find($id)
        ]);
    }

    public function editEventForm($id) {
        return view('events/event-edit', [
            'event' => Event::with('musicians')->find($id),
        ]);
    }

    public function addEvent(Request $request) {
        $event = new Event();
        $event->name = $request->name;
        $event->address = $request->address;
        $event->date = $request->date;
        $event->time = $request->time;
        $event->description = $request->description;
        $event->ticketPrice = $request->ticketPrice;
        $event->save();

        // Adds genres to the pivot table
        $event->musicians()->sync($request->musicians);

        return redirect('/events');
    }

    public function editEvent($id, Request $request) {
        $requestData = $request->except(['_token', "_method"]);

        $event = Event::find($id);
        $event->update($requestData);

        $event->musicians()->sync($request->musicians);

        return redirect('/events');
    }

    public function deleteEvent($id) {
        $event = Event::find($id);
        $event->delete();

        return redirect('/events');
    }
}
