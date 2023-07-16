<?php

use App\Models\Event;
use App\Models\Musician;
use App\Models\Song;
use Illuminate\Support\Facades\Route;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome/welcome');
});


// Musicians

// GET
Route::get('/musicians', function () {
    $musician = new Musician();

    return view('musicians/musicians', [
        'musicians' => $musician->all()
    ]);
});

Route::get('/musicians/add', function () {
    return view('musicians/musician-add');
});

Route::get('/musicians/{musician}', function ($id) {
    $musician = new Musician();

    return view('musicians/musician',[
        'musician' => $musician->find($id)
    ]);
})->whereUuid('musician');

Route::get('/musicians/edit/{musician}', function ($id) {
    $musician = new Musician();

    return view('musicians/musician-edit', [
        'musician' => $musician->find($id)
    ]);
})->whereUuid('musician');

// POST
Route::post('/musicians/add', function (Illuminate\Http\Request $request) {
    $musician = Musician::createFromArray($request->all());
    $musician->add();

    return redirect('/musicians');
});

// PATCH
Route::patch('/musicians/edit/{musician}', function ($id, Illuminate\Http\Request $request) {
    $musician = Musician::createFromArray($request->all());
    $musician->uuid = $id;
    $musician->edit();

    return redirect('/musicians');
})->whereUuid('musician');

// DELETE
Route::delete('/musicians/remove/{musician}', function ($id) {
    $musician = new Musician();
    $musician->remove($id);

    return redirect('/musicians');
})->whereUuid('musician');





// Songs

// GET
Route::get('/songs', function () {
    $song = new Song();

    return view('songs/songs', [
        'songs' => $song->all()
    ]);
});

Route::get('/songs/add', function () {
    $musician = new Musician();

    return view('songs/song-add', [
        'musicians' => $musician->all()
    ]);
});

Route::get('/songs/{song}', function ($id) {
    $song = new Song();
    $song = $song->find($id);
    $musician = new Musician();

    return view('songs/song',[
        'song' => $song,
        'musician' => $musician->find($song->musician),
    ]);
})->whereUuid('song');

Route::get('/songs/edit/{song}', function ($id) {
    $song = new Song();
    $musicians = new Musician();

    return view('songs/song-edit', [
        'song' => $song->find($id),
        'musicians' => $musicians->all(),
    ]);
})->whereUuid('song');

// POST
Route::post('/songs/add', function (Illuminate\Http\Request $request) {
    $song = Song::createFromArray($request->all());
    $song->add();

    return redirect('/songs');
});

// PATCH
Route::patch('/songs/edit/{song}', function ($id, Illuminate\Http\Request $request) {
    $song = Song::createFromArray($request->all());
    $song->uuid = $id;
    $song->edit();

    return redirect('/songs');
})->whereUuid('song');

// DELETE
Route::delete('/songs/remove/{song}', function ($id) {
    $song = new Song();
    $song->remove($id);

    return redirect('/songs');
})->whereUuid('song');





// Events

// GET
Route::get('/events', function () {
    $event = new Event();

    return view('events/events',[
        'events' => $event->all()
    ]);
});

Route::get('/events/add', function () {
    return view('events/event-add');
});

Route::get('/events/{event}', function ($id) {
    $event = new Event();

    return view('events/event',[
        'event' => $event->find($id)
    ]);
})->whereUuid('event');

Route::get('/events/edit/{event}', function ($id) {
    $event = new Event();
    $musicians = new Musician();

    return view('events/event-edit', [
        'event' => $event->find($id),
        'musicians' => $musicians->all(),
    ]);
})->whereUuid('event');

// POST
Route::post('/events/add', function (Illuminate\Http\Request $request) {
    $event = Event::createFromArray($request->all());
    $event->add();

    return redirect('/events');
});

// PATCH
Route::patch('/events/edit/{event}', function ($id, Illuminate\Http\Request $request) {
    $event = Event::createFromArray($request->all());
    $event->uuid = $id;
    $event->edit();

    return redirect('/events');
})->whereUuid('event');

// DELETE
Route::delete('/events/remove/{event}', function ($id) {
    $event = new Event();
    $event->remove($id);

    return redirect('/events');
})->whereUuid('event');

