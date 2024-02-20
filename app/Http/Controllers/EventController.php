<?php
namespace App\Http\Controllers;
use App\Http\Requests\EventRequest;
use App\Models\Event;
use App\Models\EventParticipant;
use App\Models\Musician;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use PHPUnit\Exception;
class EventController extends Controller
{
    /**
     * Fetches all events
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAllEvents(Request $request) {
        $keyword = $request->query('keyword');
        if ($keyword != null) {
            $events = $this->searchEventsByKeyword($keyword);
        } else {
            $events = Event::with('musicians')->get();
        }

        return response()->json([
            'message' => 'Successful',
            'data' => [
                'events' => $events
            ]
        ]);
    }

    /**
     * Adds a user to the attendees of an event
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function addAttendee(Request $request) {
        try {
            $validated = $request->validate([
                'event_id' => ['required', 'exists:events,id'],
                'email' => ['required', 'email', 'exists:users,email']
            ]);
            $event_id = $validated['event_id'];
            $email = $validated['email'];
            $event = Event::findOrFail($event_id);
            if (!$event) {
                return response()->json(['error' => 'Event not found']);
            }
            $user = User::where('email', $email)->first();
            if (!$user) {
                return response()->json(['error' => 'User not found']);
            }
            EventParticipant::firstOrCreate([
                'user_id' => $user->id,
                'event_id' => $event->id,
            ]);
            return response()->json(['message' => 'Added successfully']);
        } catch (\Exception $exception) {
            return response()->json($exception);
        }
    }
    /**
     * Removes a user from the attendees of an event
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function removeAttendee(Request $request) {
        try {
            $validated = $request->validate([
                'event_id' => ['required', 'exists:events,id'],
                'email' => ['required', 'email', 'exists:users,email']
            ]);
            $event_id = $validated['event_id'];
            $email = $validated['email'];
            $event = Event::findOrFail($event_id);
            if (!$event) {
                return response()->json(['error' => 'Event not found']);
            }
            $user = User::where('email', $email)->first();
            if (!$user) {
                return response()->json(['error' => 'User not found']);
            }
            EventParticipant::where([
                'user_id' => $user->id,
                'event_id' => $event_id,
            ])->delete();
            return response()->json(['message' => 'Removed successfully']);
        } catch (\Exception $exception) {
            return response()->json($exception);
        }
    }
    /**
     * Fetches all the events that a certain user is attending
     *
     * @param User $user
     * @return \Illuminate\Http\JsonResponse
     */
    public function getUsersEvents($email)
    {
        $user = User::where('email', $email)->first();

        return response()->json($user->attending()->with('musicians')->get());
    }

    /**
     * Fetches a single event
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function getEventApi(string $id) {
        return response()->json([
            'message' => 'Success',
            'data' => [
                'event' => Event::with('musicians', 'participants', 'user')->findOrFail($id)
            ]
        ]);
    }
    public function allEvents(EventRequest $request) {
        $sortOrderMap = getOrderMap(
            "events",
            $request->input('field'),
            ["name", "address", "date", "time", "description", "ticketPrice", "musician"]
        );
        if ($request->has('keyword')) {
            $events = $this->searchEventsByKeyword($request->keyword);
        } else {
            $events = $this->searchEventsByFilter($request->order, $request->field);
        }
        return view('events/events',[
            'events' => $events,
            'sortOrder' => $sortOrderMap,
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
            })->with('musicians')
            ->get();
    }
}
