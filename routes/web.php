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
    return view('layout/header');
});

Route::prefix('musicians')->group(function() {
    Route::get('/', [MusicianController::class, 'allMusicians'])->name('musicians.list');
    Route::get('/add', [MusicianController::class, 'addMusicianForm'])->name('musicians.addForm');
    Route::get('/{musician}', [MusicianController::class, 'getMusician'])->whereUuid('musician')->name('musicians.get');;
    Route::get('/edit/{musician}', [MusicianController::class, 'editMusicianForm'])->whereUuid('musician')->name('musicians.editForm');;

    Route::post('/add', [MusicianController::class, 'addMusician'])->name('musicians.add');

    Route::patch('/edit/{musician}', [MusicianController::class, 'editMusician'])->whereUuid('musician')->name('musicians.edit');

    Route::delete('/remove/{musician}', [MusicianController::class, 'deleteMusician'])->whereUuid('musician')->name('musicians.delete');
});


Route::prefix('songs')->group(function() {
    Route::get('/', [SongController::class, 'allSongs'])->name('songs.list');
    Route::get('/add', [SongController::class, 'addSongForm'])->name('songs.addForm');
    Route::get('/{song}', [SongController::class, 'getSong'])->whereUuid('song')->name('songs.get');
    Route::get('/edit/{song}', [SongController::class, 'editSongForm'])->whereUuid('song')->name('songs.editForm');

    Route::post('/add', [SongController::class, 'addSong'])->name('songs.add');

    Route::patch('/edit/{song}', [SongController::class, 'editSong'])->whereUuid('song')->name('songs.edit');

    Route::delete('/remove/{song}', [SongController::class, 'deleteSong'])->whereUuid('song')->name('songs.delete');
});


Route::prefix('events')->group(function() {
    Route::get('/', [EventController::class, 'allEvents'])->name('events.list');
    Route::get('/add', [EventController::class, 'addEventForm'])->name('events.addForm');
    Route::get('/{event}', [EventController::class, 'getEvent'])->whereUuid('event')->name('events.get');
    Route::get('/edit/{event}', [EventController::class, 'editEventForm'])->whereUuid('event')->name('events.editForm');

    Route::post('/add', [EventController::class, 'addEvent'])->name('events.add');

    Route::patch('/edit/{event}', [EventController::class, 'editEvent'])->whereUuid('event')->name('events.edit');

    Route::delete('/remove/{event}', [EventController::class, 'deleteEvent'])->whereUuid('event')->name('events.delete');
});


