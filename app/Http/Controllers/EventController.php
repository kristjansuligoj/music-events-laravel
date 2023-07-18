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
            'event' => [],
            'musicians' => Musician::all(),
            'errors' => [],
        ]);
    }

    public function getEvent($id) {
        return view('events/event',[
            'event' => Event::with('musicians')->find($id)
        ]);
    }

    public function editEventForm($id) {
        return view('events/event-add', [
            'event' => Event::with('musicians')->find($id),
            'musicians' => Musician::all(),
            'errors' => [],
        ]);
    }

    public function addEvent(Request $request) {
        $validated = $this->validateData($request);

        if ($validated->fails()) {
            return view('events/event-add', [
                'event' => $request->all(),
                'musicians' => Musician::all(),
                'errors' => $validated->errors()->messages(),
            ]);
        }

        $event = new Event();
        $event->name = $request->name;
        $event->address = $request->address;
        $event->date = $request->date;
        $event->time = $request->time;
        $event->description = $request->description;
        $event->ticketPrice = $request->ticketPrice;
        $event->save();

        // Adds genres to the pivot table
        $event->musicians()->sync($request->musician);

        return redirect('/events');
    }

    public function editEvent($id, Request $request) {
        $validated = $this->validateData($request);

        if ($validated->fails()) {
            return view('events/event-add', [
                'event' => $request->all(),
                'musicians' => Musician::all(),
                'errors' => $validated->errors()->messages(),
            ]);
        }

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

    public function validateData($data) {
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