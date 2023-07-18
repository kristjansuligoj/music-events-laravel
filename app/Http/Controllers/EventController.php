<?php

namespace App\Http\Controllers;

use App\Models\CopyMusician;
use App\Models\Event;
use App\Models\EventCopy;
use App\Models\Musician;
use App\Models\Song;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EventController extends Controller
{
    public function allEvents() {
        return view('events/events',[
            'events' => Event::all()
        ]);
    }

    public function addEventForm() {
        return view('events/event-add', [
            'action' => 'add',
            'event' => [],
            'musicians' => Musician::all(),
            'errors' => [],
        ]);
    }

    public function getEvent($id) {
        return view('components/display',[
            'component' => "event",
            'data' => Event::with('musicians')->find($id)
        ]);
    }

    public function editEventForm($id) {
        return view('events/event-add', [
            'action' => 'edit',
            'event' => Event::with('musicians')->find($id),
            'musicians' => Musician::all(),
            'errors' => [],
        ]);
    }

    public function addEvent(Request $request) {
        $validated = $this->validateData($request);

        if ($validated->fails()) {
            return view('events/event-add', [
                'action' => 'add',
                'event' => $request->all(),
                'musicians' => Musician::all(),
                'errors' => $validated->errors()->messages(),
            ]);
        }

        $eventData = $request->all();
        $event = Event::create($eventData);

        // Adds genres to the pivot table
        $event->musicians()->sync($eventData['musician']);

        return redirect('/events');
    }

    public function editEvent($id, Request $request) {
        $validated = $this->validateData($request, $id);

        if ($validated->fails()) {
            $event = $request->all();
            $event['id'] = $id;
            return view('events/event-add', [
                'action' => 'edit',
                'event' => $event,
                'musicians' => Musician::all(),
                'errors' => $validated->errors()->messages(),
            ]);
        }

        $requestData = $request->except(['_token', "_method"]);

        $event = Event::find($id);
        $event->update($requestData);

        $event->musicians()->sync($request->musician);

        return redirect('/events');
    }

    public function deleteEvent($id) {
        $event = Event::find($id);
        $event->delete();

        return redirect('/events');
    }

    public function validateData($data, $id = null) {
        if ($id != null) {
            return Validator::make($data->all(), [
                'name' => ['required', 'unique:events,name,'.$id],
                'address' => ['required', 'unique:events,address,'.$id],
                'date' => ['required', 'date', 'after:today'],
                'time' => ['required'],
                'description' => ['required'],
                'ticketPrice' => ['required', 'integer', 'between:10,300'],
            ]);
        }
        return Validator::make($data->all(), [
            'name' => ['required', 'unique:events,name'],
            'address' => ['required', 'unique:events,address'],
            'date' => ['required', 'date', 'after:today'],
            'time' => ['required'],
            'description' => ['required'],
            'ticketPrice' => ['required', 'integer', 'between:10,300'],
        ]);
    }
}
