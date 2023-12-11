<?php

namespace App\Http\Controllers;

use App\Http\Requests\NoteRequest;
use GuzzleHttp\Psr7\MultipartStream;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use GuzzleHttp\Client;
use Illuminate\Support\MessageBag;

class NoteController extends Controller
{
    public function authentication(Request $request) {
        $authenticate = $this->authenticate($request->password);

        $errors = new MessageBag();

        $errors->add('password', "User credentials are not valid. Are you sure you are registered on both sites?");

        if (!$authenticate) {
            return view('notes.authentication-form')->withErrors($errors);
        }

        return view('notes.notes', [
            'notes' => $this->fetchNotes(),
        ]);
    }

    public function allNotes() {
        if (session('luka-app-token')) {
            return view('notes.notes', [
                'notes' => $this->fetchNotes(),
            ]);
        }

        if (auth()->user()) {
            return view('notes.authentication-form');
        }

        return view('auth.login');
    }
    public function addNoteForm(Request $request) {
        $categories = $this->fetchCategories();

        return view('notes.note-add', [
            'note' => null,
            'categories' => $categories
        ]);
    }

    public function editNoteForm($note) {
        $note = $this->fetchNote($note);
        $categories = $this->fetchCategories();

        return view('notes.note-add', [
            'note' => $note,
            'categories' => $categories,
        ]);
    }

    public function addNote(NoteRequest $request) {
        try {
            $client = new Client();

            $boundary = uniqid();

            $response = $client->request('POST', 'http://localhost:8001/api/note/store', [
                'headers' => [
                    'Authorization' => 'Bearer ' . session('luka-app-token'),
                    'Content-Type' => 'multipart/form-data; boundary=' . $boundary,
                    'Accept' => 'application/json',
                ],
                'body' => new MultipartStream([
                    [
                        'name'     => 'user_id',
                        'contents' => $request->user_id,
                    ],
                    [
                        'name'     => 'category_id',
                        'contents' => $request->category_id,
                    ],
                    [
                        'name'     => 'title',
                        'contents' => $request->title,
                    ],
                    [
                        'name'     => 'content',
                        'contents' => $request->noteContent,
                    ],
                    [
                        'name'     => 'priority',
                        'contents' => $request->priority,
                    ],
                    [
                        'name'     => 'deadline',
                        'contents' => $request->deadline,
                    ],
                    [
                        'name'     => 'tags',
                        'contents' => $request->tags,
                    ],
                    [
                        'name'     => 'public',
                        'contents' => $request->public,
                    ]
                ], $boundary),
            ]);

            $this->fetchNotes();

            return redirect()->route('notes.list');
        } catch(\Exception $e) {
            info($e);
            return $e;
        }
    }

    public function editNote(NoteRequest $request) {
        try {
            $client = new Client();

            $response = $client->request('PATCH', 'http://localhost:8001/api/note/store', [
                'headers' => [
                    'Authorization' => 'Bearer ' . session('luka-app-token'),
                    'Content-Type' => 'application/json',
                    'Accept' => 'application/json',
                ],
                'body' => json_encode([
                    'id' => $request->id,
                    'user_id' => $request->user_id,
                    'category_id' => $request->category_id,
                    'title' => $request->title,
                    'content' => $request->noteContent,
                    'priority' => $request->priority,
                    'deadline' => $request->deadline,
                    'tags' => $request->tags,
                    'public' => $request->public,
                ])
            ]);

            $this->fetchNotes();

            return redirect()->route('notes.list');
        } catch(\Exception $e) {
            info($e);
            return $e;
        }
    }

    public function removeNote($id) {
        try {
            $client = new Client();

            $response = $client->request('DELETE', 'http://localhost:8001/api/note/destroy/' . $id, [
                'headers' => [
                    'Authorization' => 'Bearer ' . session('luka-app-token'),
                    'Accept' => 'application/json',
                ],
            ]);

            return redirect()->route('notes.list');
        } catch(\Exception $e) {
            info($e);
            return $e;
        }
    }

    public function fetchCategories() {
        try {
            $client = new Client();

            $response = $client->request('GET', 'http://localhost:8001/api/category/', [
                'headers' => [
                    'Authorization' => 'Bearer ' . session('luka-app-token'),
                    'Accept' => 'application/json',
                ],
            ]);

            $categories = json_decode($response->getBody(), true);

            return $categories;
        } catch(\Exception $e) {
            info($e);
            return $e;
        }
    }

    public function fetchNotes() {
        try {
            $client = new Client();

            $user = auth()->user();

            if (!$user) {
                dd("Not logged in.");
            }

            $response = $client->request('GET', 'http://localhost:8001/api/note/' . $user->name, [
                'headers' => [
                    'Authorization' => 'Bearer ' . session('luka-app-token'),
                    'Accept' => 'application/json',
                ],
            ]);

            $notes = json_decode($response->getBody(), true);

            Cache::put($user->username . '-notes', $notes, 30);

            return $notes;
        } catch(\Exception $e) {
            info($e);
            return $e;
        }
    }

    public function fetchNote($noteId) {
        try {
            $client = new Client();

            $response = $client->request('GET', 'http://localhost:8001/api/note/getById/' . $noteId, [
                'headers' => [
                    'Authorization' => 'Bearer ' . session('luka-app-token'),
                    'Accept' => 'application/json',
                ],
            ]);

            $note = json_decode($response->getBody(), true);

            return (object)$note['notes'];
        } catch(\Exception $e) {
            info($e);
            return $e;
        }
    }

    public function authenticate($password) {
        $client = new Client();

        $boundary = uniqid();

        $user = auth()->user();

        if (!$user) {
            dd("Not logged in.");
        }

        try {
            $response = $client->request('POST', 'http://localhost:8001/api/tokens/authenticate', [
                'headers' => [
                    'Content-Type' => 'multipart/form-data; boundary=' . $boundary,
                    'Accept' => 'application/json',
                ],
                'body' => new MultipartStream([
                    [
                        'name'     => 'email',
                        'contents' => $user->email,
                    ],
                    [
                        'name'     => 'password',
                        'contents' => $password,
                    ]
                ], $boundary),
            ]);

            session(['luka-app-token' => json_decode($response->getBody(), true)['token']]);
            session(['user_id' => json_decode($response->getBody(), true)['user_id']]);

            return true;
        } catch(\Exception $e) {
            return false;
        }
    }
}
