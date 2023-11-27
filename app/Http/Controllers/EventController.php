<?php

namespace App\Http\Controllers;

use App\Http\Requests\EventRequest;
use App\Models\Event;
use App\Models\EventParticipant;
use App\Models\Musician;
use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class EventController extends Controller
{
    public function allEvents(EventRequest $request) {
        if ($request->has('keyword')) {
            $events = $this->searchEventsByKeyword($request->keyword);
        } else {
            $events = $this->searchEventsByFilter($request->order, $request->field);
        }

        return view('events/events',[
            'events' => $events
        ]);
    }

    public function addEventForm() {
        return view('events/event-add', [
            'event' => null,
            'musicians' => Musician::all(),
        ]);
    }

    public function getEvent($id) {
        $event = Event::with('musicians', 'participants', 'user')->findOrFail($id);
        $event->time = Carbon::parse($event->time)->format("H:i");

        return view('events/event',[
            'event' => $event
        ]);
    }

    public function addUserToEvent($eventId, $userId) {
        $event = Event::find($eventId);

        if (!$event) {
            return redirect()->route('events.list');
        }

        $user = User::find($userId);

        if (!$user) {
            return redirect()->route('events.list');
        }

        $eventParticipant = EventParticipant::firstOrCreate([
            'user_id' => $userId,
            'event_id' => $eventId,
        ]);

        return redirect('events/' . $eventId);
    }

    public function removeUserFromEvent($eventId, $userId) {
        $event = Event::find($eventId);

        if (!$event) {
            redirect('events/' . $eventId);
        }

        $user = User::find($userId);

        if (!$user) {
            redirect('events/' . $eventId);
        }

        EventParticipant::where([
            'user_id' => $userId,
            'event_id' => $eventId,
        ])->delete();

        return redirect('events/' . $eventId);
    }

    public function editEventForm($id) {
        return view('events/event-add', [
            'event' => Event::with('musicians')->findOrFail($id),
            'musicians' => Musician::all(),
        ]);
    }

    public function addEvent(EventRequest $request) {
        $eventData = $request->all();
        $eventData['user_id'] = Auth::user()->id;
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

    public function searchEventsByFilter($sortOrder, $sortField) {
        if ($sortOrder === null) {
            return Event::paginate(7);
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

    public function searchEventsByKeyword($keyword) {
        return Event::where('name', 'LIKE', '%' . $keyword . '%')
            ->orWhere('address', 'LIKE', '%' . $keyword . '%')
            ->orWhere('date', 'LIKE', '%' . $keyword . '%')
            ->orWhere('time', 'LIKE', '%' . $keyword . '%')
            ->orWhere('description', 'LIKE', '%' . $keyword . '%')
            ->orWhere('ticketPrice', 'LIKE', '%' . $keyword . '%')
            ->orWhereHas('musicians', function ($query) use ($keyword) {
                $query->where('name', 'LIKE', '%' . $keyword . '%');
            })
            ->paginate(7);
    }
}
