<?php

namespace App\Http\Controllers;

use App\Helpers\NoteClient;
use App\Http\Requests\NoteRequest;
use Exception;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

/**
 * This class is used for managing notes from Lukas' note managing app.
 * It uses his API, to send and receive note data.
 */
class NoteController extends Controller
{
    public function __construct(
        protected NoteClient $noteClient
    ) {}

    /**
     * Fetches all notes from the logged user or prompts for authentication
     *
     * @return View|RedirectResponse
     */
    public function allNotes(): View | RedirectResponse
    {
        try {
            return view('notes.notes', [
                'notes' => $this->noteClient->fetchNotes(),
            ]);
        } catch (GuzzleException $e) {
            return handleGuzzleException($e);
        } catch (Exception $e) {
            return handleException($e);
        }
    }

    /**
     * Returns a view for adding a new note
     *
     * @return View|RedirectResponse
     */
    public function addNoteForm(): View | RedirectResponse
    {
        try {
            $categories = $this->noteClient->fetchCategories();

            return view('notes.note-add', [
                'note' => null,
                'categories' => $categories
            ]);
        } catch (GuzzleException $e) {
            return handleGuzzleException($e);
        } catch (Exception $e) {
            return handleException($e);
        }
    }

    /**
     * Adds a note
     *
     * @param NoteRequest $request
     * @return View|RedirectResponse
     */
    public function addNote(NoteRequest $request): View | RedirectResponse
    {
        try {
            $this->noteClient->addNote($request);

            return redirect()->route('notes.list');
        } catch (GuzzleException $e) {
            return handleGuzzleException($e);
        } catch (Exception $e) {
            return handleException($e);
        }
    }

    /**
     * Returns a view for editing a note
     *
     * @param $noteId
     * @return View|RedirectResponse
     */
    public function editNoteForm($noteId): View | RedirectResponse
    {
        try {
            $note = $this->noteClient->fetchNote($noteId);
            $categories = $this->noteClient->fetchCategories();

            return view('notes.note-add', [
                'note' => $note,
                'categories' => $categories,
            ]);
        } catch (GuzzleException $e) {
            return handleGuzzleException($e);
        } catch (Exception $e) {
            return handleException($e);
        }
    }

    /**
     * Edits a note
     *
     * @param $noteId
     * @param NoteRequest $request
     * @return View|RedirectResponse
     */
    public function editNote($noteId, NoteRequest $request): View | RedirectResponse
    {
        try {
            $this->noteClient->editNote($noteId, $request);

            return redirect()->route('notes.list');
        } catch (GuzzleException $e) {
            return handleGuzzleException($e);
        } catch (Exception $e) {
            return handleException($e);
        }
    }

    /**
     * Returns authentication form
     *
     * @return View
     */
    public function authenticationForm(): View
    {
        return view('notes.authentication-form');
    }

    /**
     * Tries to authenticate with Lukas' app, so his API can be used
     *
     * @param Request $request
     * @return View|RedirectResponse
     */
    public function authenticate(Request $request): View | RedirectResponse
    {
        try {
            $this->noteClient->authenticate($request->password);

            return redirect()->route('notes.list');
        } catch (GuzzleException $e) {
            return handleGuzzleException($e);
        } catch (Exception $e) {
            return handleException($e);
        }
    }

    /**
     * Removes note with the given id
     *
     * @param $noteId
     * @return View|RedirectResponse
     */
    public function removeNote($noteId): View | RedirectResponse
    {
        try {
            $this->noteClient->removeNote($noteId);

            return redirect()->route('notes.list');
        } catch (GuzzleException $e) {
            return handleGuzzleException($e);
        } catch (Exception $e) {
            return handleException($e);
        }
    }
}
