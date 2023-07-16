<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MusicianController;
use App\Http\Controllers\SongController;
use App\Http\Controllers\EventController;
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


// GET
Route::get('/musicians', [MusicianController::class, 'allMusicians']);

Route::get('/musicians/add', [MusicianController::class, 'addMusicianForm']);

Route::get('/musicians/{musician}', [MusicianController::class, 'getMusician'])
    ->whereUuid('musician');

Route::get('/musicians/edit/{musician}', [MusicianController::class, 'editMusicianForm'])
    ->whereUuid('musician');

Route::get('/songs', [SongController::class, 'allSongs']);

Route::get('/songs/add', [SongController::class, 'addSongForm']);

Route::get('/songs/{song}', [SongController::class, 'getSong'])
    ->whereUuid('song');

Route::get('/songs/edit/{song}', [SongController::class, 'editSongForm'])
    ->whereUuid('song');

Route::get('/events', [EventController::class, 'allEvents']);

Route::get('/events/add', [EventController::class, 'addEventForm']);

Route::get('/events/{event}', [EventController::class, 'getEvent'])
    ->whereUuid('event');

Route::get('/events/edit/{event}', [EventController::class, 'editEventForm'])
    ->whereUuid('event');

// POST
Route::post('/musicians/add', [MusicianController::class, 'addMusician']);
Route::post('/songs/add', [SongController::class, 'addSong']);
Route::post('/events/add', [EventController::class, 'addEvent']);

// PATCH
Route::patch('/musicians/edit/{musician}', [MusicianController::class, 'editMusician'])
    ->whereUuid('musician');

Route::patch('/songs/edit/{song}', [SongController::class, 'editSong'])
    ->whereUuid('song');

Route::patch('/events/edit/{event}', [EventController::class, 'editEvent'])
    ->whereUuid('event');

// DELETE
Route::delete('/musicians/remove/{musician}', [MusicianController::class, 'deleteMusician'])
    ->whereUuid('musician');

Route::delete('/songs/remove/{song}', [SongController::class, 'deleteSong'])
    ->whereUuid('song');

Route::delete('/events/remove/{event}', [EventController::class, 'deleteEvent'])
    ->whereUuid('event');


