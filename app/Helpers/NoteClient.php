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
    protected mixed $baseUrl;
    protected Client $client;

    public function __construct()
    {
        $this->baseUrl = env('LUKA_APP_URL');
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
        checkLoggedIn();

        try {
            $response = $this->client->request('POST', $this->baseUrl . 'tokens/authenticate', [
                'headers' => [
                    'Content-Type' => 'application/json',
                    'Accept' => 'application/json',
                ],
                'json' => [
                    'email' => $user->email,
                    'password' => $password
                ]
            ]);

            session(['luka-app-token' => json_decode($response->getBody(), true)['token']]);
            session(['user_id' => json_decode($response->getBody(), true)['user_id']]);
        } catch(GuzzleException $e) {
            throw $e;
        }
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
        checkLoggedIn();

        try {
            $response = $this->client->request('GET', $this->baseUrl . 'notes', [
                'headers' => [
                    'Authorization' => 'Bearer ' . session('luka-app-token'),
                    'Accept' => 'application/json',
                ],
            ]);

            return json_decode($response->getBody(), true);
        } catch(GuzzleException $e) {
            throw $e;
        }
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
        checkLoggedIn();

        try {
            $response = $this->client->request('GET', $this->baseUrl . 'notes/' . $noteId, [
                'headers' => [
                    'Authorization' => 'Bearer ' . session('luka-app-token'),
                    'Accept' => 'application/json',
                ],
            ]);

            return json_decode($response->getBody());
        } catch(GuzzleException $e) {
            throw $e;
        }
    }

    /**
     * Fetches all categories
     *
     * @throws GuzzleException
     * @throws Exception
     */
    public function fetchCategories()
    {
        checkLoggedIn();

        try {
            $response = $this->client->request('GET', $this->baseUrl . 'categories', [
                'headers' => [
                    'Authorization' => 'Bearer ' . session('luka-app-token'),
                    'Accept' => 'application/json',
                ],
            ]);

            return json_decode($response->getBody(), true);
        } catch(GuzzleException $e) {
            throw $e;
        }
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
        checkLoggedIn();

        try {
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
        } catch(GuzzleException $e) {
            throw $e;
        }
    }

    /**
     * Edits a note
     *
     * @throws GuzzleException
     * @throws Exception
     */
    public function editNote($noteId, NoteRequest $request): int
    {
        checkLoggedIn();

        try {
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
        } catch(GuzzleException $e) {
            throw $e;
        }
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
        checkLoggedIn();

        try {
            $response = $this->client->request('DELETE', $this->baseUrl . 'notes/' . $noteId, [
                'headers' => [
                    'Authorization' => 'Bearer ' . session('luka-app-token'),
                    'Accept' => 'application/json',
                ],
            ]);

            return $response->getStatusCode();
        } catch(GuzzleException $e) {
            throw $e;
        }
    }
}
