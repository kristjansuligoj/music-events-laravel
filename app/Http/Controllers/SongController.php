<?php

namespace App\Http\Controllers;

use App\Models\Musician;
use App\Models\Song;
use Illuminate\Http\Request;

class SongController extends Controller
{
    public function allSongs() {
        $song = new Song();

        return view('songs/songs', [
            'songs' => $song->all()
        ]);
    }

    public function addSongForm() {
        $musician = new Musician();

        return view('songs/song-add', [
            'musicians' => $musician->all()
        ]);
    }

    public function getSong($id) {
        $song = new Song();
        $song = $song->find($id);
        $musician = new Musician();

        return view('songs/song',[
            'song' => $song,
            'musician' => $musician->find($song->musician),
        ]);
    }

    public function editSongForm($id) {
        $song = new Song();
        $musicians = new Musician();

        return view('songs/song-edit', [
            'song' => $song->find($id),
            'musicians' => $musicians->all(),
        ]);
    }

    public function addSong(Request $request) {
        $song = Song::createFromArray($request->all());
        $song->add();

        return redirect('/songs');
    }

    public function editSong($id, Request $request) {
        $song = Song::createFromArray($request->all());
        $song->uuid = $id;
        $song->edit();

        return redirect('/songs');
    }

    public function deleteSong($id) {
        $song = new Song();
        $song->remove($id);

        return redirect('/songs');
    }
}
