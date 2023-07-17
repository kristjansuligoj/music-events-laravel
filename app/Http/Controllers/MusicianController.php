<?php

namespace App\Http\Controllers;

use App\Models\CopyMusician;
use App\Models\Musician;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MusicianController extends Controller
{
    public function allMusicians() {
        return view('musicians/musicians', [
            'musicians' => Musician::all()
        ]);
    }

    public function addMusicianForm() {
        return view('musicians/musician-add', [
            'musicians' => [],
            'errors' => [],
        ]);
    }

    public function getMusician($id) {
        return view('musicians/musician',[
            'musician' => Musician::with('genres')->find($id)
        ]);
    }

    public function editMusicianForm($id) {
        return view('musicians/musician-add', [
            'musician' => Musician::find($id),
            'errors' => []
        ]);
    }

    public function addMusician(Request $request) {
        $validated = $this->validateData($request);

        if ($validated->fails()) {
            return view('musicians/musician-add', [
                'musician' => $request->all(),
                'errors' => $validated->errors()->messages(),
            ]);
        }

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
        $validated = $this->validateData($request);

        if ($validated->fails()) {
            return view('musicians/musician-add', [
                'musician' => $request->all(),
                'errors' => $validated->errors()->messages(),
            ]);
        }

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

    public function validateData($data) {
        return Validator::make($data->all(), [
            'name' => ['required', 'unique:musicians,name'],
            'genre' => ['required'],
        ]);
    }
}
