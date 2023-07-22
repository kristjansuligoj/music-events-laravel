<?php

use Illuminate\Support\Facades\File;

function printArray($data, $field): string {
        $html = "";

        foreach($data as $field) {
            $html .= "<li>" . $field->name . "</li>";
        }

        return $html;
    }

    function saveImage($request): string {
        $fileName = time() . '.' . $request->image->extension();
        $request->image->move(public_path('images'), $fileName);
        return $fileName;
    }

    function deleteImage($path): void {
        if(File::exists('images/' . $path)) {
            File::delete('images/' . $path);
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
