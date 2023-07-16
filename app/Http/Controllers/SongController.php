<?php

namespace App\Http\Controllers;

use App\Models\Author;
use App\Models\CopyMusician;
use App\Models\Musician;
use App\Models\Song;
use App\Models\SongCopy;
use Illuminate\Http\Request;

class SongController extends Controller
{
    public function allSongs() {
        return view('songs/songs', [
            'songs' => Song::all()
        ]);
    }

    public function addSongForm() {
        return view('songs/song-add', [
            'musicians' => Musician::all()
        ]);
    }

    public function getSong($id) {
        return view('songs/song',[
            'song' => Song::with('musician', 'genres', 'authors')->find($id)
        ]);
    }

    public function editSongForm($id) {
        return view('songs/song-edit', [
            'song' => Song::with('authors')->find($id),
            'musicians' => Musician::all()
        ]);
    }

    public function addSong(Request $request) {
        $song = new Song();
        $song->musician_id = $request->musician;
        $song->title = $request->title;
        $song->length = $request->length;
        $song->releaseDate = $request->releaseDate;
        $song->save();

        // Adds genres to the pivot table
        $song->genres()->sync(genreToIndex($request->genre));

        // Adds authors to the pivot table
        $authorNames = explode(',', $request->authors); // Assuming author names are comma-separated

        foreach ($authorNames as $authorName) {
            $author = new Author();
            $author->name = trim($authorName); // Trim any whitespace around the author name
            $song->authors()->save($author);
        }

        return redirect('/songs');
    }

    public function editSong($id, Request $request) {
        $requestData = $request->except(['_token', "_method"]);
        $requestData['musician_id'] = $requestData['musician'];
        unset($requestData['musician']);

        $song = Song::find($id);
        $song->update($requestData);

        $song->genres()->sync(genreToIndex($request->genre));

        return redirect('/songs');
    }

    public function deleteSong($id) {
        $song = Song::find($id);
        $song->delete();

        return redirect('/songs');
    }
}
