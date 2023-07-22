<?php

namespace App\Http\Controllers;

use App\Http\Requests\SongRequest;
use App\Models\Author;
use App\Models\Musician;
use App\Models\Song;

class SongController extends Controller
{
    public function allSongs() {
        return view('songs/songs', [
            'songs' => Song::all()
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

        return redirect('/songs');
    }

    public function editSong($id, SongRequest $request) {
        $songData = $request->except(['_token', "_method"]);
        $songData['musician_id'] = $songData['musician'];
        unset($songData['musician']);

        $song = Song::findOrFail($id);
        $song->update($songData);

        $song->genres()->sync(genreToIndex($request->genre));

        return redirect('/songs');
    }

    public function deleteSong($id) {
        $song = Song::findOrFail($id);
        $song->delete();

        return redirect('/songs');
    }
}
