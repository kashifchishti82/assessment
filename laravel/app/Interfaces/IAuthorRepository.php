<?php

namespace App\Interfaces;

use App\Models\Author;
use Illuminate\Database\Eloquent\Collection;

interface IAuthorRepository
{
    public function getAllAuthors(): Collection;

    public function getAuthorById(int $id): Author|null;

    public function getAuthorByNames(string|array $name): array;

    public function create(array $data): Author| null;

    public function update(int $id, array $data): Author|null;

    public function delete(int $id): null;
}
