<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\ImageController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MusicianController;
use App\Http\Controllers\NoteController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SongController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::get('/events', [EventController::class, 'getAllEvents']);
Route::get('/attending/{id}', [EventController::class, 'getUsersEvents']);

Route::group(['prefix' => 'images', 'middleware' => ['auth:sanctum']], function() {
    Route::post('/', [ImageController::class, 'addImage']);
    Route::post('/{image}', [ImageController::class, 'removeImage']);
});

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/events/{id}/attendees', [EventController::class, 'addAttendee']);
    Route::delete('/events/{id}/attendees/{attendeesEmail}', [EventController::class, 'removeAttendee']);
});

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::group(['prefix' => 'notes', 'middleware' => ['auth:sanctum']], function () {
    Route::get('/authenticationForm', [NoteController::class, 'authenticationForm'])->name('notes.authenticationForm');
    Route::post('/authenticate', [NoteController::class, 'authenticate'])->name('notes.authenticate');

    Route::middleware('auth.luka-app')->group(function () {
        Route::get('/', [NoteController::class, 'allNotes'])->name('notes.list');
        Route::get('/add', [NoteController::class, 'addNoteForm'])->name('notes.addForm');
        Route::post('/add', [NoteController::class, 'addNote'])->name('notes.add');
        Route::get('/edit/{note}', [NoteController::class, 'editNoteForm'])->whereUuid('note')->name('notes.editForm');
        Route::patch('/edit/{note}', [NoteController::class, 'editNote'])->whereUuid('note')->name('notes.edit');
        Route::delete('/remove/{note}', [NoteController::class, 'removeNote'])->whereUuid('note')->name('notes.remove');
    });
});

Route::prefix('musicians')->group(function () {
    Route::get('/', [MusicianController::class, 'allMusicians'])->name('musicians.list');
    Route::get('/unpaginated', [MusicianController::class, 'allMusiciansUnpaginated'])->name('musicians.listUnpaginated');
    Route::get('/{musician}', [MusicianController::class, 'getMusician'])->whereUuid('musician')->name('musicians.get');;

    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/add', [MusicianController::class, 'addMusician'])->name('musicians.add');
        Route::patch('/edit/{musician}', [MusicianController::class, 'editMusician'])->whereUuid('musician')->name('musicians.edit');
        Route::delete('/remove/{musician}', [MusicianController::class, 'deleteMusician'])->whereUuid('musician')->name('musicians.delete');
    });
});


Route::prefix('songs')->group(function () {
    Route::get('/', [SongController::class, 'allSongs'])->name('songs.list');
    Route::get('/{song}', [SongController::class, 'getSong'])->whereUuid('song')->name('songs.get');

    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/add', [SongController::class, 'addSong'])->name('songs.add');
        Route::patch('/edit/{song}', [SongController::class, 'editSong'])->whereUuid('song')->name('songs.edit');
        Route::delete('/remove/{song}', [SongController::class, 'deleteSong'])->whereUuid('song')->name('songs.delete');
    });
});


Route::prefix('events')->group(function () {
    Route::get('/', [EventController::class, 'allEvents'])->name('events.list');
    Route::get('/{event}', [EventController::class, 'getEvent'])->whereUuid('event')->name('events.get');

    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/history/{user}', [EventController::class, 'eventHistory'])->name('events.eventsHistory');
        Route::post('/add', [EventController::class, 'addEvent'])->name('events.add');
        Route::post('/{event}/add-user/{user}', [EventController::class, 'addUserToEvent'])->whereUuid(['event', 'user'])->name('events.addUserToEvent');
        Route::post('/{event}/remove-user/{user}', [EventController::class, 'removeUserFromEvent'])->whereUuid(['event', 'user'])->name('events.removeUserFromEvent');
        Route::patch('/edit/{event}', [EventController::class, 'editEvent'])->whereUuid('event')->name('events.edit');
        Route::delete('/remove/{event}', [EventController::class, 'deleteEvent'])->whereUuid('event')->name('events.delete');
    });
});

require __DIR__ . '/auth.php';
