<?php

    function printArray($data, $field): string {
        $html = "";

        foreach($data as $field) {
            $html .= "<li>" . $field->name . "</li>";
        }

        return $html;
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
