<?php

namespace App\Http\Controllers;

use App\Models\Musician;
use Illuminate\Http\Request;

class MusicianController extends Controller
{
    public function allMusicians() {
        $musician = new Musician();

        return view('musicians/musicians', [
            'musicians' => $musician->all()
        ]);
    }

    public function addMusicianForm() {
        return view('musicians/musician-add');
    }

    public function getMusician($id) {
        $musician = new Musician();

        return view('musicians/musician',[
            'musician' => $musician->find($id)
        ]);
    }

    public function editMusicianForm($id) {
        $musician = new Musician();

        return view('musicians/musician-edit', [
            'musician' => $musician->find($id)
        ]);
    }

    public function addMusician(Request $request) {
        $musician = Musician::createFromArray($request->all());
        $musician->add();

        return redirect('/musicians');
    }

    public function editMusician($id, Request $request) {
        $musician = Musician::createFromArray($request->all());
        $musician->uuid = $id;
        $musician->edit();

        return redirect('/musicians');
    }

    public function deleteMusician($id) {
        $musician = new Musician();
        $musician->remove($id);

        return redirect('/musicians');
    }
}
