<?php

namespace App\Http\Controllers;

use App\Models\Author;
use App\Models\CopyMusician;
use App\Models\Musician;
use App\Models\Song;
use App\Models\SongCopy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class SongController extends Controller
{
    public function allSongs() {
        return view('songs/songs', [
            'songs' => Song::all()
        ]);
    }

    public function addSongForm() {
        return view('songs/song-add', [
            'song' => [],
            'musicians' => Musician::all(),
            'errors' => [],
        ]);
    }

    public function getSong($id) {
        return view('songs/song',[
            'song' => Song::with('musician', 'genres', 'authors')->find($id)
        ]);
    }

    public function editSongForm($id) {
        $song = Song::with('authors')->find($id);

        // Because authors are saved separately, we need to concatenate them to a string
        $authorsAsString = "";
        foreach($song->authors as $author) {
            $authorsAsString .= $author->name . ",";
        }
        $authorsAsString = substr($authorsAsString, 0, -1);

        // Save the authors as a single string
        $song['authors'] = $authorsAsString;

        return view('songs/song-add', [
            'song' => $song,
            'musicians' => Musician::all(),
            'errors' => []
        ]);
    }

    public function addSong(Request $request) {
        $validated = $this->validateData($request);

        if ($validated->fails()) {
            return view('songs/song-add', [
                'song' => [],
                'musicians' => Musician::all(),
                'errors' => $validated->errors()->messages(),
            ]);
        }

        $song = new Song();
        $song->musician_id = $request->musician;
        $song->title = $request->title;
        $song->length = $request->length;
        $song->releaseDate = $request->releaseDate;
        $song->save();

        // Adds genres to the pivot table
        $song->genres()->sync(genreToIndex($request->genre));

        // Explode the authors by comma
        $authorNames = explode(',', $request->authors);

        // Save every author to the table
        foreach ($authorNames as $authorName) {
            $author = new Author();
            $author->name = trim($authorName); // Trim any whitespace around the author name
            $song->authors()->save($author);
        }

        return redirect('/songs');
    }

    public function editSong($id, Request $request) {
        $validated = $this->validateData($request);

        if ($validated->fails()) {
            return view('songs/song-add', [
                'song' => $request->all(),
                'musicians' => Musician::all(),
                'errors' => $validated->errors()->messages(),
            ]);
        }

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

    public function validateData($data) {
        return Validator::make($data->all(), [
            'musician' => 'required',
            'title' => ['required', 'unique:songs,title'],
            'length' => ['required', 'integer', 'between:10,300'],
            'releaseDate' => ['required', 'date', 'before:today'],
            'authors' => ['required'],
        ]);
    }
}