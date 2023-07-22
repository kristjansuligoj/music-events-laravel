<?php

namespace App\Http\Controllers;

use App\Http\Requests\MusicianRequest;
use App\Models\Musician;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
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
            'musician' => null,
        ]);
    }

    public function getMusician($id) {
        return view('components/display',[
            'component' => "musician",
            'data' => Musician::with('genres')->findOrFail($id)
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

        return redirect('/musicians');
    }

    public function editMusician($id, MusicianRequest $request) {
        $requestData = $request->except(['_token', "_method"]);

        // Save the image
        $fileName = saveImage($request);

        $requestData['image'] = $fileName;

        // Deletes the old image
        deleteImage($musician->image);
        $musician->update($requestData);

        // Updates genres in the pivot table
        $musician->genres()->sync(genreToIndex($request->genre));

        return redirect('/musicians');
    }

    public function deleteMusician($id) {
        $musician = Musician::find($id);
        $musician->delete();

        deleteImage($musician->image);

        return redirect('/musicians');
    }

    public function validateData($data, $id=null) {
        if ($id != null) {
            return Validator::make($data->all(), [
                'name' => ['required', 'unique:musicians,name,'.$id],
                'genre' => ['required'],
                'image' => ['required'],
            ]);
        }
        return Validator::make($data->all(), [
            'name' => ['required', 'unique:musicians,name'],
            'genre' => ['required'],
            'image' => ['required'],
        ]);
    }
}
