<?php

namespace App\Repositories;

use App\Interfaces\IAuthorRepository;
use App\Models\Author;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Arr;

class AuthorRepository implements IAuthorRepository
{
    public function __construct(private Author $model){}
    public function getAllAuthors(): Collection
    {
        return $this->model->all();
    }

    public function getAuthorById(int $id): Author|null
    {
        // TODO: Implement getAuthorById() method.
    }

    public function findOrCreate(string $string)
    {
        return $this->model->firstOrCreate(
            ['name' => $string]
        );
    }

    public function getAuthorByNames(string|array $names): array
    {
        $collections = [];
        if (is_array($names)) {
            foreach ($names as $name) {
                $collections[] = $this->findOrCreate($name);
            }
        } else {
            $collections[] = $this->findOrCreate($names);
        }
        return $collections;
    }

    public function create(array $data): Author|null
    {
        // TODO: Implement create() method.
    }

    public function update(int $id, array $data): Author|null
    {
        // TODO: Implement update() method.
    }

    public function delete(int $id): null
    {
        // TODO: Implement delete() method.
    }
}
