<?php

namespace App\Http\Controllers;

use App\Models\CopyMusician;
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

        $fileName = time() . '.' . $request->image->extension();
        $request->image->move(public_path('images'), $fileName);

        $musician = new Musician();
        $musician->name = $request->name;
        $musician->image = $fileName;
        $musician->save();

        // Adds genres to the pivot table
        $musician->genres()->sync(genreToIndex($request->genre));

        return redirect('/musicians');
    }

    public function editMusician($id, Request $request) {
        $validated = $this->validateData($request, $id);

        if ($validated->fails()) {
            return view('musicians/musician-add', [
                'musician' => $request->all(),
                'errors' => $validated->errors()->messages(),
            ]);
        }

        $requestData = $request->except(['_token', "_method"]);

        $fileName = time() . '.' . $request->image->extension();
        $request->image->move(public_path('images'), $fileName);
        $requestData['image'] = $fileName;

        $musician = Musician::find($id);
        $musician->update($requestData);

        // Updates genres in the pivot table
        $musician->genres()->sync(genreToIndex($request->genre));

        return redirect('/musicians');
    }

    public function deleteMusician($id) {
        $musician = Musician::find($id);
        $musician->delete();

        if(File::exists('images/' . $musician->image)) {
            File::delete('images/' . $musician->image);
        }

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
