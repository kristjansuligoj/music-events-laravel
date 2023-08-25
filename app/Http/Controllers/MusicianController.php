<?php

namespace App\Http\Controllers;

use App\Http\Requests\MusicianRequest;
use App\Models\Musician;
use Illuminate\Support\Facades\File;

class MusicianController extends Controller
{
    public function allMusicians(MusicianRequest $request) {
        if ($request->has('keyword')) {
            $musicians = $this->searchMusiciansByKeyword($request->keyword);
        } else {
            $musicians = $this->searchMusiciansByFilter($request->order, $request->field);
        }

        return view('musicians/musicians', [
            'musicians' => $musicians
        ]);
    }

    public function addMusicianForm() {
        return view('musicians/musician-add', [
            'musician' => null,
        ]);
    }

    public function getMusician($id) {
        return view('musicians/musician',[
            'musician' => Musician::with('genres')->findOrFail($id)
        ]);
    }

    public function editMusicianForm($id) {
        return view('musicians/musician-add', [
            'musician' => Musician::with('genres')->findOrFail($id),
        ]);
    }

    public function addMusician(MusicianRequest $request) {
        // Save the image
        $fileName = saveImage($request);

        // Create the musician
        $musicianData = $request->all();
        $musicianData['image'] = $fileName;
        $musician = Musician::create($musicianData);

        // Adds genres to the pivot table
        $musician->genres()->sync(genreToIndex($musicianData['genre']));

        return redirect()->route('musicians.list');
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

        return redirect()->route('musicians.list');
    }

    public function searchMusiciansByFilter($sortOrder, $sortField) {
        if ($sortOrder === null) {
            return Musician::paginate(7);
        } else {
            if ($sortField === "genre") {
                return Musician::join('musicians_genres', 'musicians.id', '=', 'musicians_genres.musician_id')
                    ->join('genres', 'musicians_genres.genre_id', '=', 'genres.id')
                    ->orderBy('genres.name', $sortOrder)
                    ->select('musicians.*')
                    ->paginate(7);
            } else {
                return Musician::orderBy($sortField, $sortOrder)->paginate(7);
            }
        }
    }

    public function searchMusiciansByKeyword($keyword) {
        return Musician::where('name', 'LIKE', '%' . $keyword . '%')
            ->orWhereHas('genres', function ($query) use ($keyword) {
                $query->where('name', 'LIKE', '%' . $keyword . '%');
            })
            ->paginate(7);
    }
}
