<?php

namespace App\Http\Controllers;

use App\Http\Requests\SongRequest;
use App\Models\Author;
use App\Models\Musician;
use App\Models\Song;
use Illuminate\Support\Facades\Session;

class SongController extends Controller
{
    public function allSongs(SongRequest $request) {
        $sortOrderMap = getOrderMap(
            "songs",
            $request->input('field'),
            ["title", "genre", "length", "releaseDate", "authors", "musician"]
        );

        if ($request->has('keyword')) {
            $songs = $this->searchSongsByKeyword($request->keyword);
        } else {
            $songs = $this->searchSongsByFilter($request->order, $request->field);
        }

        return view('songs/songs', [
            'songs' => $songs,
            'sortOrder' => $sortOrderMap,
        ]);
    }

    public function addSongForm() {
        return view('songs/song-add', [
            'song' => null,
            'musicians' => Musician::all(),
        ]);
    }

    public function getSong($id) {
        return view('songs/song',[
            'song' => Song::with('musician', 'genres', 'authors')->findOrFail($id)
        ]);
    }

    public function editSongForm($id) {
        $song = Song::with('musician', 'genres', 'authors')->findOrFail($id);

        // Save the authors as a single string
        $song['authors'] = authorsToString($song->authors);

        return view('songs/song-add', [
            'song' => $song,
            'musicians' => Musician::all(),
        ]);
    }

    public function addSong(SongRequest $request) {
        $songData = $request->except(['genre', 'authors']);
        $songData['musician_id'] = $request->musician;
        $song = Song::create($songData);

        // Adds genres to the pivot table
        $song->genres()->sync(genreToIndex($request->genre));

        saveAuthorsToTable($request->authors, $song);

        return redirect()->route('songs.list');
    }

    public function editSong($id, SongRequest $request) {
        $songData = $request->except(['_token', "_method"]);
        $songData['musician_id'] = $songData['musician'];
        unset($songData['musician']);

        $song = Song::findOrFail($id);
        $song->update($songData);

        $song->genres()->sync(genreToIndex($request->genre));

        return redirect()->route('songs.list');
    }

    public function deleteSong($id) {
        $song = Song::findOrFail($id);
        $song->delete();

        return redirect()->route('songs.list');
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
