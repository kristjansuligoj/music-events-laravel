<?php

use App\Models\Author;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

function printArray($data, $field): string {
        $html = "";

        foreach($data as $field) {
            $html .= "<li class=\"m-2\">" . $field->name . "</li>";
        }

        return $html;
    }

    function saveImage($request): string {
        $imageData = $request->image;
        $data = substr($imageData, strpos($imageData, ',') + 1);
        $decodedImage = base64_decode($data);
        $fileName = time() . '.' . explode("/", $request->type)[1];
        File::put(public_path('images/musicians/' . $fileName), $decodedImage);
        return $fileName;
    }

    function deleteImage($path): void {
        if(File::exists('images/musicians' . $path)) {
            File::delete('images/musicians' . $path);
        }
    }

    function genreToIndex($genres): array {
        $genreIds = [];
        foreach($genres as $genre) {
            switch ($genre) {
                case "Rock":
                    $genreIds[] = 1;
                    break;
                case "Metal":
                    $genreIds[] = 2;
                    break;
                case "Rap":
                    $genreIds[] = 3;
                    break;
                case "Country":
                    $genreIds[] = 4;
                    break;
                case "Hip hop":
                    $genreIds[] = 5;
                    break;
                case "Jazz":
                    $genreIds[] = 6;
                    break;
                case "Electronic":
                    $genreIds[] = 7;
                    break;
            }
        }

        return $genreIds;
    }

    function displayErrorIfExists($errors, $field) {
        if(isset($errors[$field])) echo $errors[$field][0];
    }

    function authorsToString($authors): string {
        $authorsAsString = "";
        foreach($authors as $author) {
            $authorsAsString .= $author->name . ",";
        }
        return substr($authorsAsString, 0, -1);
    }

    function saveAuthorsToTable($authors, $song): void {
        // Explode the authors by comma
        $authorNames = explode(',', $authors);

        // Save every author to the table
        foreach ($authorNames as $authorName) {
            $author = new Author();
            $author->name = trim($authorName); // Trim any whitespace around the author name
            $song->authors()->save($author);
        }
    }

    function getOrderMap($whichMap, $field, $defaultOrders): array {
        $key = "";

        switch($whichMap) {
            case 'musicians':
                $key = 'sortOrderMapMusicians';
                break;
            case 'events':
                $key = 'sortOrderMapEvents';
                break;
            case 'songs':
                $key = 'sortOrderMapSongs';
                break;
            default:
                return [];
        }

        $sortOrderMap = Session::get($key, []);

        if ($field) {
            $sortOrderMap[$field] = ($sortOrderMap[$field] === 'asc') ? 'desc' : (($sortOrderMap[$field] === 'desc') ? '' : 'asc');
        } else {
            foreach ($defaultOrders as $defaultField) {
                $sortOrderMap[$defaultField] = 'asc';
            }
        }

        Session::put($key, $sortOrderMap);

        return $sortOrderMap;
    }

    /**
     * Handles GuzzleExceptions based on the status code
     *
     * @param GuzzleException $e
     * @return RedirectResponse|View
     */
    function handleGuzzleException(GuzzleException $e): RedirectResponse | View
    {
        Log::error($e);

        switch($e->getCode()) {
            case 401:
                return view('auth.login');
            case 403:
                abort(403, 'You are can not access this note.');
            case 404:
                abort(404, 'Note not found.');
            case 422:
                $response = json_decode($e->getResponse()->getBody(), true);

                if (isset($response['errors'])) {
                    $errorMessages = $response['errors'];
                    return redirect()->route('notes.authenticationForm')->with('serverErrors', $errorMessages);
                }

                abort(422, 'Provided data is invalid.');
            default:
                abort(500, 'Something went wrong.');
        }
    }

    /**
     * Handles exception when user is not logged in
     *
     * @param Exception $e
     * @return View
     *
     */
    function handleException(Exception $e): View
    {
        Log::error($e);

        return view('auth.login');
    }
