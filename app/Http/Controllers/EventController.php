<?php

namespace App\Http\Controllers;

use App\Http\Requests\EventRequest;
use App\Models\Event;
use App\Models\EventParticipant;
use App\Models\Musician;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
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
            $events
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

        return response()->json($user->attending()->get());
    }

    /**
     * Fetches a single event
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function getEventApi(string $id) {
        return response()->json(Event::with('musicians', 'participants', 'user')->findOrFail($id));
    }

    public function allEvents(EventRequest $request) {
        $sortOrderMap = getOrderMap(
            "events",
            $request->input('field'),
            ["name", "address", "date", "time", "description", "ticketPrice", "musician"]
        );

        if ($request->has('keyword')) {
            $events = $this->searchEventsByKeyword($request->keyword, (bool)$request->showAttending);
        } else {
            $events = $this->searchEventsByFilter($request->order, $request->field, (bool)$request->showAttending);
        }

        return response()->json([
            'success' => true,
            'data' => [
                'events' => $events,
                'sortOrder' => $sortOrderMap,
            ],
            'message' => 'Events successfully retrieved.'
        ]);
    }

    public function getEvent($id) {
        $event = Event::with('musicians', 'participants', 'user')->findOrFail($id);
        $event->time = Carbon::parse($event->time)->format("H:i");

        return response()->json([
            'success' => true,
            'data' => [
              'event' => $event,
            ],
            'message' => "Event successfully retrieved",
        ]);
    }

    /**
     * This function returns all the events the user has attended
     *
     * @return JsonResponse
     */
    public function eventHistory($user): JsonResponse
    {
        $events = Event::join('event_participants', 'events.id', '=', 'event_participants.event_id')
            ->where('event_participants.user_id', $user)
            ->whereDate('events.date', '<', now())
            ->select('events.*')
            ->paginate(7);

        return response()->json([
            'success' => true,
            'data' => [
                'events' => $events
            ],
            'message' => "Event history successfully retrieved."
        ]);
    }

    public function addUserToEvent($eventId, $userId) {
        $event = Event::find($eventId);

        if (!$event || Carbon::parse($event->date)->lt(Carbon::now())) {
            return response()->json([
                'success' => false,
                'data' => [
                    'event' => $eventId,
                ],
                'message' => "Event does not exist."
            ]);
        }

        $user = User::find($userId);

        if (!$user) {
            return response()->json([
                'success' => false,
                'data' => [
                    'user' => $userId,
                ],
                'message' => "User does not exist."
            ]);
        }

        EventParticipant::firstOrCreate([
            'user_id' => $userId,
            'event_id' => $eventId,
        ]);

        return response()->json([
            'success' => true,
            'data' => [
                'user' => $user,
                'event' => $event,
            ],
            'message' => "User successfully added to event."
        ]);
    }

    public function removeUserFromEvent($eventId, $userId) {
        $event = Event::find($eventId);

        if (!$event) {
            return response()->json([
                'success' => false,
                'data' => [
                    'event' => $eventId,
                ],
                'message' => "Event does not exist."
            ]);
        }

        $user = User::find($userId);

        if (!$user) {
            return response()->json([
                'success' => false,
                'data' => [
                    'user' => $userId,
                ],
                'message' => "User does not exist."
            ]);
        }

        EventParticipant::where([
            'user_id' => $userId,
            'event_id' => $eventId,
        ])->delete();

        return response()->json([
            'success' => true,
            'data' => [
                'user' => $user,
                'event' => $event,
            ],
            'message' => "User successfully removed from event."
        ]);
    }

    public function addEvent(EventRequest $request) {
        $eventData = $request->all();
        $eventData['user_id'] = Auth::user()->id;
        $event = Event::create($eventData);

        // Adds genres to the pivot table
        $event->musicians()->sync($eventData['musician']);

        return response()->json([
            'success' => true,
            'data' => [
                'event' => $event,
            ],
            'message' => "Event successfully added."
        ]);
    }

    public function editEvent($id, EventRequest $request) {
        $eventData = $request->except(['_token', "_method"]);

        $event = Event::findOrFail($id);
        $event->update($eventData);

        $event->musicians()->sync($request->musician);

        return response()->json([
            'success' => true,
            'data' => [
                'event' => $event,
            ],
            'message' => "Event successfully edited."
        ]);
    }

    public function deleteEvent($id) {
        $event = Event::findOrFail($id);
        $event->delete();

        return response()->json([
            'success' => true,
            'data' => [
                'event' => $id,
            ],
            'message' => "Event successfully removed."
        ]);
    }

    public function searchEventsByFilter($sortOrder, $sortField, $showAttending = false)
    {
        $query = Event::query();

        if ($showAttending) {
            $query->join('event_participants', 'events.id', '=', 'event_participants.event_id')
                ->where('event_participants.user_id', auth()->user()->id);
        }

        if ($sortField === "musician") {
            $query->join('events_musicians', 'events.id', '=', 'events_musicians.event_id')
                ->join('musicians', 'events_musicians.musician_id', '=', 'musicians.id');

            if (in_array(strtolower($sortOrder), ['asc', 'desc'])) {
                $query->orderBy('musicians.name', $sortOrder);
            }
        } elseif ($sortOrder !== null) {
            $query->orderBy($sortField, $sortOrder);
        }

        return $query->with('musicians')->select('events.*')->paginate(7);
    }

    public function searchEventsByKeyword($keyword, $showAttending = false) {
        if ($showAttending) {
            return Event::join('event_participants', 'events.id', '=', 'event_participants.event_id')
                ->where('event_participants.user_id', auth()->user()->id)
                ->where(function ($query) use ($keyword) {
                    $query->where('name', 'LIKE', '%' . $keyword . '%')
                        ->orWhere('address', 'LIKE', '%' . $keyword . '%')
                        ->orWhere('date', 'LIKE', '%' . $keyword . '%')
                        ->orWhere('time', 'LIKE', '%' . $keyword . '%')
                        ->orWhere('description', 'LIKE', '%' . $keyword . '%')
                        ->orWhere('ticketPrice', 'LIKE', '%' . $keyword . '%')
                        ->orWhereHas('musicians', function ($subquery) use ($keyword) {
                            $subquery->where('name', 'LIKE', '%' . $keyword . '%');
                        });
                })
                ->with('musicians')
                ->select('events.*')
                ->paginate(7);
        } else {
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
}
