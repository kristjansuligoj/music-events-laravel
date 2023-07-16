<?php

namespace App\Models;

use App\Helpers\Database;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;
use Ramsey\Uuid\Uuid;

abstract class Model
{
    private string $table;
    public string $uuid;

    protected Database $database;

    public function __construct()
    {
        $this->table = strtolower((new \ReflectionClass($this))->getShortName()) . 's';
        $this->uuid = Uuid::uuid4();
        $this->database = new Database();
    }

    public function find(string $id): ?Model {
        $elements = $this->all();

        if (count($elements) == 0) {
            return null;
        }

        if (isset($elements[$id])) {
            return $elements[$id];
        }

        return null;
    }

    public function all(): array
    {
        Cache::clear();

        return cache()->remember($this->table, 60*60, function () {
            $documents = $this->database->loadDocument($this->table);
            $model = get_called_class();
            $elements = [];
            $modelInstance = new $model();

            foreach($documents as $document) {
                $element = $modelInstance::createFromArray($document);
                $element->uuid = $document['uuid'];
                $elements[$document['uuid']] = $element;
            }

            return $elements;
        });
    }

    public function add(): bool {
        return $this->database->addElement($this->table, $this);
    }

    public function edit(): void {
        $this->database->editElement($this->table, $this);
    }

    public function remove(string $uuid): bool {
        return $this->database->removeElement($this->table, $uuid);
    }
}
