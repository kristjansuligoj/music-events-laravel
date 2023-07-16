<?php

namespace App\Http\Controllers;

use App\Models\CopyMusician;
use App\Models\Musician;
use Illuminate\Http\Request;

class MusicianController extends Controller
{
    public function allMusicians() {
        return view('musicians/musicians', [
            'musicians' => Musician::all()
        ]);
    }

    public function addMusicianForm() {
        return view('musicians/musician-add');
    }

    public function getMusician($id) {
        return view('musicians/musician',[
            'musician' => Musician::with('genres')->find($id)
        ]);
    }

    public function editMusicianForm($id) {
        return view('musicians/musician-edit', [
            'musician' => Musician::find($id)
        ]);
    }

    public function addMusician(Request $request) {
        $musician = new Musician();
        $musician->name = $request->name;
        // $musician->image = $request->image;
        $musician->image = "test.png";
        $musician->save();

        // Adds genres to the pivot table
        $musician->genres()->sync(genreToIndex($request->genre));

        return redirect('/musicians');
    }

    public function editMusician($id, Request $request) {
        $requestData = $request->except(['_token', "_method"]);

        $musician = Musician::find($id);
        $musician->update($requestData);

        // Updates genres in the pivot table
        $musician->genres()->sync(genreToIndex($request->genre));

        return redirect('/musicians');
    }

    public function deleteMusician($id) {
        $musician = Musician::find($id);
        $musician->delete();

        return redirect('/musicians');
    }
}
