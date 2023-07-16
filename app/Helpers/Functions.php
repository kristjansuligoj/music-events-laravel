<?php

    function printArray($data, $field): string {
        $html = "";

        foreach($data->$field as $field) {
            $html .= "<li>" . $field . "</li>";
        }

        return $html;
    }
