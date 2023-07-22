<?php

namespace App\Http\Controllers;

use App\Http\Requests\SongRequest;
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
            'song' => null,
            'musicians' => Musician::all(),
        ]);
    }

    public function getSong($id) {
        return view('components/display',[
            'component' => 'song',
            'data' => Song::with('musician', 'genres', 'authors')->findOrFail($id)
        ]);
    }

    public function editSongForm($id) {
        $song = Song::with('musician', 'genres', 'authors')->findOrFail($id);

        // Because authors are saved separately, we need to concatenate them to a string
        $authorsAsString = "";
        foreach($song->authors as $author) {
            $authorsAsString .= $author->name . ",";
        }
        $authorsAsString = substr($authorsAsString, 0, -1);

        // Save the authors as a single string
        $song['authors'] = $authorsAsString;

        return view('songs/song-add', [
            'action' => 'edit',
            'song' => $song,
            'musicians' => Musician::all(),
            'errors' => []
        ]);
    }

    public function addSong(SongRequest $request) {
        $songData = $request->except(['genre', 'authors']);
        $song = Song::create($songData);

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

    public function editSong($id, SongRequest $request) {
        $requestData = $request->except(['_token', "_method"]);
        $requestData['musician_id'] = $requestData['musician'];
        unset($requestData['musician']);

        $song = Song::findOrFail($id);
        $song->update($requestData);

        $song->genres()->sync(genreToIndex($request->genre));

        return redirect('/songs');
    }

    public function deleteSong($id) {
        $song = Song::findOrFail($id);
        $song->delete();

        return redirect('/songs');
    }

    public function validateData($data, $id=null) {
        if ($id != null) {
            return Validator::make($data->all(), [
                'musician' => 'required',
                'title' => ['required', 'unique:songs,title,'.$id],
                'length' => ['required', 'integer', 'between:10,300'],
                'releaseDate' => ['required', 'date', 'before:today'],
                'authors' => ['required'],
            ]);
        }
        return Validator::make($data->all(), [
            'musician' => 'required',
            'title' => ['required', 'unique:songs,title'],
            'length' => ['required', 'integer', 'between:10,300'],
            'releaseDate' => ['required', 'date', 'before:today'],
            'authors' => ['required'],
        ]);
    }
}
