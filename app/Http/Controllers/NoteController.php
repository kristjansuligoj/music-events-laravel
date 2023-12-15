<?php

namespace App\Http\Controllers;

use App\Helpers\NoteClient;
use App\Http\Requests\NoteRequest;
use GuzzleHttp\Psr7\MultipartStream;
use Exception;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use GuzzleHttp\Client;
use Illuminate\Support\MessageBag;

class NoteController extends Controller
{
    protected NoteClient $noteClient;

        return view('notes.notes', [
            'notes' => $this->fetchNotes(),
        ]);
    public function __construct(NoteClient $noteClient) {
        $this->noteClient = $noteClient;
    }

    public function allNotes() {
        if (session('luka-app-token')) {
            return view('notes.notes', [
                'notes' => $this->fetchNotes(),
            ]);
        }
    public function allNotes()
        try {
                    'notes' => $this->noteClient->fetchNotes(),

        if (auth()->user()) {
            return view('notes.authentication-form');
        } catch (Exception $e) {
            handleException($e);
        } catch (GuzzleException $e) {
            handleGuzzleException($e);
        }

        return view('auth.login');
    }
    public function addNoteForm(Request $request) {
        $categories = $this->fetchCategories();
    public function addNoteForm()
        try {
            $categories = $this->noteClient->fetchCategories();

        return view('notes.note-add', [
            'note' => null,
            'categories' => $categories
        ]);
        } catch (Exception $e) {
            handleException($e);
        } catch (GuzzleException $e) {
            handleGuzzleException($e);
        }
    }

    public function editNoteForm($note) {
        $note = $this->fetchNote($note);
        $categories = $this->fetchCategories();
    public function addNote(NoteRequest $request)
        try {
            $this->noteClient->addNote($request);
        } catch (GuzzleException $e) {
            return handleGuzzleException($e);
        } catch (Exception $e) {
            handleException($e);
        }
    public function editNoteForm($noteId)
        try {
            $note = $this->noteClient->fetchNote($noteId);
            $categories = $this->noteClient->fetchCategories();

        return view('notes.note-add', [
            'note' => $note,
            'categories' => $categories,
        ]);
        } catch (Exception $e) {
            handleException($e);
        } catch (GuzzleException $e) {
            handleGuzzleException($e);
        }
    }

    public function addNote(NoteRequest $request) {
    public function editNote($noteId, NoteRequest $request)
        try {
            $this->noteClient->editNote($noteId, $request);

            return redirect()->route('notes.list');
        } catch(\Exception $e) {
            info($e);
            return $e;
        } catch (Exception $e) {
            handleException($e);
        } catch (GuzzleException $e) {
            handleGuzzleException($e);
        }
    }

    public function editNote(NoteRequest $request) {
    public function authenticate(Request $request)
        try {
            $this->noteClient->authenticate($request->password);

            return redirect()->route('notes.list');
        } catch(\Exception $e) {
            info($e);
            return $e;
        } catch (Exception $e) {
            handleException($e);
        } catch (GuzzleException $e) {
            handleGuzzleException($e);
        }
    }

    public function removeNote($id) {
    public function removeNote($noteId)
        try {
            $this->noteClient->removeNote($noteId);

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
        } catch (Exception $e) {
            handleException($e);
        } catch (GuzzleException $e) {
            handleGuzzleException($e);
        }
    }
}
