<?php

namespace App\Http\Controllers;

use App\Http\Requests\MusicianRequest;
use App\Models\Event;
use App\Models\Musician;
use App\Models\Song;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;

class MusicianController extends Controller
{
    public function allMusicians(MusicianRequest $request) {
        $sortOrderMap = getOrderMap(
            "musicians",
            $request->input('field'),
            ["name", "genre"]
        );

        if ($request->has('keyword')) {
            $musicians = $this->searchMusiciansByKeyword($request->keyword);
        } else {
            $musicians = $this->searchMusiciansByFilter($request->order, $request->field);
        }

        return response()->json([
            'success' => true,
            'data' => [
                'musicians' => $musicians,
                'sortOrder' => $sortOrderMap,
            ],
            'message' => 'Musicians received',
        ]);
    }

    public function addMusicianForm() {
        return view('musicians/musician-add', [
            'musician' => null,
        ]);
    }

    public function getMusician($id) {
        return response()->json([
            'success' => true,
            'data' => [
                'musician' => Musician::with('genres', 'songs', 'events', 'user')->findOrFail($id),
                'usedElsewhere' => $this->checkMusicianUsage($id)
            ],
            'message' => 'Musicians received',
        ]);
    }

    public function editMusicianForm($id) {
        return view('musicians/musician-add', [
            'musician' => Musician::with('genres')->findOrFail($id),
        ]);
    }

    public function addMusician(MusicianRequest $request) {
        // Create the musician
        $musicianData = $request->all();
        $musicianData['image'] = $request->get('image');
        $musicianData['user_id'] = Auth::user()->id;

        $musician = Musician::create($musicianData);

        // Adds genres to the pivot table
        $musician->genres()->sync($musicianData['genre']);

        return response()->json([
            'success' => true,
            'data' => $musician,
            'message' => "Musician successfully added."
        ]);
    }

    public function editMusician($id, MusicianRequest $request) {
        $musicianData = $request->except(['_token', "_method"]);

        // Save the image
        $fileName = saveImage($request);
        $musicianData['image'] = $fileName;

        $musician = Musician::findOrFail($id);

        // Deletes the old image
        deleteImage($musician->image);
        $musician->update($musicianData);

        // Updates genres in the pivot table
        $musician->genres()->sync(genreToIndex($request->genre));

        return redirect()->route('musicians.list');
    }

    public function deleteMusician($id) {
        $musician = Musician::findOrFail($id);
        $musician->delete();

        deleteImage($musician->image);

        return response()->json([
            'success' => true,
            'data' => $id,
            'message' => 'Musician removed',
        ]);
    }

    public function searchMusiciansByFilter($sortOrder, $sortField) {
        if ($sortOrder === null) {
            return Musician::join('musicians_genres', 'musicians.id', '=', 'musicians_genres.musician_id')
                ->join('genres', 'musicians_genres.genre_id', '=', 'genres.id')
                ->select('musicians.*')
                ->with('songs')
                ->with('events')
                ->paginate(7);
        } else {
            if ($sortField === "genre") {
                return Musician::join('musicians_genres', 'musicians.id', '=', 'musicians_genres.musician_id')
                    ->join('genres', 'musicians_genres.genre_id', '=', 'genres.id')
                    ->orderBy('genres.name', $sortOrder)
                    ->select('musicians.*')
                    ->with('songs')
                    ->with('events')
                    ->paginate(7);
            } else {
                return Musician::join('musicians_genres', 'musicians.id', '=', 'musicians_genres.musician_id')
                    ->join('genres', 'musicians_genres.genre_id', '=', 'genres.id')
                    ->orderBy($sortField, $sortOrder)
                    ->select('musicians.*')
                    ->with('songs')
                    ->with('events')
                    ->paginate(7);
            }
        }
    }

    public function searchMusiciansByKeyword($keyword) {
        return Musician::where('name', 'LIKE', '%' . $keyword . '%')
            ->orWhereHas('genres', function ($query) use ($keyword) {
                $query->where('name', 'LIKE', '%' . $keyword . '%');
            })
            ->orWhereHas('songs', function ($query) use ($keyword) {
                $query->where('title', 'LIKE', '%' . $keyword . '%');
            })
            ->with('songs')
            ->with('events')
            ->paginate(7);
    }

    public function checkMusicianUsage($id) {
        $isUsedInEvent = Event::whereHas('musicians', function ($query) use ($id) {
            $query->where('musician_id', $id);
        })->exists();
        $isUsedInSong = Song::where('musician_id', '=', $id)->exists();

        return $isUsedInEvent || $isUsedInSong;
    }

}
