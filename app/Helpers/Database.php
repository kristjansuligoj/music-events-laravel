<?php

namespace App\Helpers;

use App\Models\Model;
use Illuminate\Support\Facades\File;

class Database
{
    public function loadDocument(string $tableName): array {
        $path = resource_path('database/');

        // Checks if database directory exists
        if (!File::exists($path)) {
            mkdir($path);
        }

        // If file does not exist, no elements exist so return []
        if (!File::exists($path . $tableName . '.json')) {
            return [];
        }

        // Return all elements in the file
        return (array) json_decode(file_get_contents($path . $tableName . '.json'), true);
    }

    public function addElement(string $tableName, Model $element): bool {
        // Loads the elements
        $elements = $this->loadDocument($tableName);

        // Saves the element with UUID as key
        $elements[$element->uuid] = $element;

        // Saves the elements
        return $this->saveElements($tableName, $elements);
    }

    /**
     * @throws \Exception
     */
    public function editElement(string $tableName, Model $element): void {
        // Loads the elements
        $elements = $this->loadDocument($tableName);

        if (!isset($elements[$element->uuid])) {
            throw new \Exception("Entry ne obstaja v bazi!");
        }

        // Saves the element with UUID as key
        $elements[$element->uuid] = $element;

        // Saves the elements
        $this->saveElements($tableName, $elements);
    }

    public function removeElement(string $tableName, string $uuid): bool {
        $elements = $this->loadDocument($tableName);

        if (isset($elements[$uuid])) {
            unset($elements[$uuid]);
        }

        return $this->saveElements($tableName, $elements);
    }

    public function saveElements(string $tableName, array $elements): bool {
        $path = resource_path('database/' . $tableName . '.json');
        return File::put($path, json_encode($elements));
    }
}
