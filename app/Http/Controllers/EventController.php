<?php

namespace App\Http\Controllers;

use App\Http\Requests\EventRequest;
use App\Models\Event;
use App\Models\EventParticipant;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class EventController extends Controller
{
    /**
     * Fetches all events
     *
     * @param EventRequest $request
     * @return JsonResponse
     */
    public function allEvents(EventRequest $request) {
        if ($request->has('keyword')) {
            $events = $this->searchEventsByKeyword($request->keyword, (bool)$request->showAttending);
        } else {
            $events = $this->searchEventsByFilter($request->order, $request->field, (bool)$request->showAttending);
        }

        return response()->json([
            'success' => true,
            'data' => [
                'events' => $events,
            ],
            'message' => 'Events successfully retrieved.'
        ]);
    }

    /**
     * Fetches specific event
     *
     * @param $eventId
     * @return JsonResponse
     */
    public function getEvent($eventId) {
        $event = Event::with('musicians', 'participants', 'user')->findOrFail($eventId);
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
    public function eventHistory($userId): JsonResponse
    {
        if (!uuid_is_valid($userId)) {
            $userId = User::where('email', $userId)->first()->id;
        }

        $events = Event::join('event_participants', 'events.id', '=', 'event_participants.event_id')
            ->with('musicians')
            ->where('event_participants.user_id', $userId)
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

    public function addUserToEvent($eventId, $userId) {
        if (!uuid_is_valid($userId)) {
            $userId = User::where('email', $userId)->first()->id;
        }

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
        if (!uuid_is_valid($userId)) {
            $userId = User::where('email', $userId)->first()->id;
        }

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

    public function editEvent($eventId, EventRequest $request) {
        $eventData = $request->except(['_token', "_method"]);

        $event = Event::findOrFail($eventId);
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

    public function deleteEvent($eventId) {
        $event = Event::findOrFail($eventId);
        $event->delete();

        return response()->json([
            'success' => true,
            'data' => [
                'event' => $eventId,
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
                ->select('events.*')
                ->paginate(7);
        }
    }
}
