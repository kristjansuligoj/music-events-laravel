<?php

namespace App\Helpers;

use App\Http\Requests\NoteRequest;
use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

/**
 * This class creates a client for communication with Lukas' API
 */
class NoteClient
{
    protected string $baseUrl;

    public function __construct(
        protected Client $client
    )
    {
        $this->baseUrl = config('luka-app.base_url');
        $this->client = new Client([
            'base_uri' => $this->baseUrl,
            'allow_redirects' => false,
        ]);
    }

    /**
     * Sends authentication data to Lukas' app, and saves the returned token and user_id into the session
     *
     * @param $password
     * @return void
     * @throws GuzzleException
     * @throws Exception
     */
    public function authenticate($password): void
    {
        $response = $this->client->request('POST', $this->baseUrl . 'tokens/authenticate', [
            'headers' => [
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
            ],
            'json' => [
                'email' => auth()->user()->email,
                'password' => $password
            ]
        ]);

        session(['luka-app-token' => json_decode($response->getBody(), true)['token']]);
    }

    /**
     * Fetches all notes
     *
     * @return array
     * @throws GuzzleException
     * @throws Exception
     */
    public function fetchNotes(): array
    {
        $response = $this->client->request('GET', $this->baseUrl . 'notes', [
            'headers' => [
                'Authorization' => 'Bearer ' . session('luka-app-token'),
                'Accept' => 'application/json',
            ],
        ]);

        return json_decode($response->getBody(), true);
    }

    /**
     * Fetches a specific note
     *
     * @param $noteId
     * @return object
     * @throws GuzzleException
     * @throws Exception
     */
    public function fetchNote($noteId): object
    {
        $response = $this->client->request('GET', $this->baseUrl . 'notes/' . $noteId, [
            'headers' => [
                'Authorization' => 'Bearer ' . session('luka-app-token'),
                'Accept' => 'application/json',
            ],
        ]);

        return json_decode($response->getBody());
    }

    /**
     * Fetches all categories
     *
     * @return mixed
     * @throws GuzzleException
     */
    public function fetchCategories(): mixed
    {
        $response = $this->client->request('GET', $this->baseUrl . 'categories', [
            'headers' => [
                'Authorization' => 'Bearer ' . session('luka-app-token'),
                'Accept' => 'application/json',
            ],
        ]);

        return json_decode($response->getBody(), true);
    }

    /**
     * Adds a new note
     *
     * @param NoteRequest $request
     * @return int
     * @throws GuzzleException
     * @throws Exception
     */
    public function addNote(NoteRequest $request): int
    {
        $response = $this->client->request('POST',  $this->baseUrl . 'notes', [
            'headers' => [
                'Authorization' => 'Bearer ' . session('luka-app-token'),
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
            ],
            'json' => [
                'category_id' => $request->category_id,
                'title' => $request->title,
                'content' => $request->noteContent,
                'priority' => $request->priority,
                'deadline' => $request->deadline,
                'tags' => $request->tags,
                'public' => $request->public,
            ]
        ]);

        return $response->getStatusCode();
    }

    /**
     * Edits a note
     *
     * @throws GuzzleException
     * @throws Exception
     */
    public function editNote($noteId, NoteRequest $request): int
    {
        $response = $this->client->request('PATCH',  $this->baseUrl . 'notes/' . $noteId, [
            'headers' => [
                'Authorization' => 'Bearer ' . session('luka-app-token'),
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
            ],
            'json' => [
                'category_id' => $request->category_id,
                'title' => $request->title,
                'content' => $request->noteContent,
                'priority' => $request->priority,
                'deadline' => $request->deadline,
                'tags' => $request->tags,
                'public' => $request->public,
            ]
        ]);

        return $response->getStatusCode();
    }

    /**
     * Removes note with the given id
     *
     * @param $noteId
     * @return int
     * @throws GuzzleException
     * @throws Exception
     */
    public function removeNote($noteId): int
    {
        $response = $this->client->request('DELETE', $this->baseUrl . 'notes/' . $noteId, [
            'headers' => [
                'Authorization' => 'Bearer ' . session('luka-app-token'),
                'Accept' => 'application/json',
            ],
        ]);

        return $response->getStatusCode();
    }
}
