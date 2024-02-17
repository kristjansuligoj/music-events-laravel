<?php

namespace App\Http\Controllers;

use App\Http\Requests\SongRequest;
use App\Models\Song;
use Illuminate\Support\Facades\Auth;

class SongController extends Controller
{
    public function allSongs(SongRequest $request) {
        if ($request->has('keyword')) {
            $songs = $this->searchSongsByKeyword($request->keyword);
        } else {
            $songs = $this->searchSongsByFilter($request->order, $request->field);
        }

        return response()->json([
            'success' => true,
            'data' => [
                'songs' => $songs,
            ],
            'message' => 'Song successfully added.'
        ]);
    }

    public function getSong($songId) {
        return response()->json([
            'success' => true,
            'data' => [
                'song' => Song::with('musician', 'genres', 'authors', 'user')->findOrFail($songId)
            ],
            'message' => 'Song successfully added.'
        ]);
    }

    public function addSong(SongRequest $request) {
        $songData = $request->except(['genre', 'authors']);
        $songData['musician_id'] = $request->musician;
        $songData['user_id'] = Auth::user()->id;
        $song = Song::create($songData);

        // Adds genres to the pivot table
        $song->genres()->sync($request->genre);

        saveAuthorsToTable($request->authors, $song);

        return response()->json([
            'success' => true,
            'data' => [
                'songs' => $song
            ],
            'message' => 'Song successfully added.'
        ]);
    }

    public function editSong($songId, SongRequest $request) {
        $songData = $request->except(['_token', "_method"]);
        $songData['musician_id'] = $songData['musician'];
        unset($songData['musician']);

        $song = Song::findOrFail($songId);
        $song->update($songData);

        $song->genres()->sync($request->genre);

        return response()->json([
            'success' => true,
            'data' => [
                'songs' => $song
            ],
            'message' => 'Song successfully edited.'
        ]);
    }

    public function deleteSong($songId) {
        $song = Song::findOrFail($songId);
        $song->delete();

        return response()->json([
            'success' => true,
            'data' => [
                'song' => $songId
            ],
            'message' => 'Song successfully removed.'
        ]);
    }

    public function searchSongsByFilter($sortOrder, $sortField) {
        if ($sortOrder === null) {
            return Song::paginate(7);
        } else {
            if ($sortField === "genre") {
                return Song::join('songs_genres', 'songs.id', '=', 'songs_genres.song_id')
                    ->join('genres', 'songs_genres.genre_id', '=', 'genres.id')
                    ->orderBy('genres.name', $sortOrder)
                    ->select('songs.*')
                    ->paginate(7);
            } else if ($sortField === "authors") {
                return Song::join('authors', 'songs.id', '=', 'authors.song_id')
                    ->orderBy('authors.name', $sortOrder)
                    ->select('songs.*')
                    ->paginate(7);
            } else if ($sortField === "musician") {
                return Song::join('musicians', 'songs.musician_id', '=', 'musicians.id')
                    ->orderBy('musicians.name', $sortOrder)
                    ->select('songs.*')
                    ->paginate(7);
            } else {
                return Song::orderBy($sortField, $sortOrder)->paginate(7);;
            }
        }
    }

    public function searchSongsByKeyword($keyword) {
        return Song::where('title', 'LIKE', '%' . $keyword . '%')
            ->orWhere('length', 'LIKE', '%' . $keyword . '%')
            ->orWhere('releaseDate', 'LIKE', '%' . $keyword . '%')
            ->orWhereHas('genres', function ($query) use ($keyword) {
                $query->where('name', 'LIKE', '%' . $keyword . '%');
            })
            ->orWhereHas('musician', function ($query) use ($keyword) {
                $query->where('name', 'LIKE', '%' . $keyword . '%');
            })
            ->paginate(7);
    }
}
