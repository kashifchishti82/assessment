<?php

namespace App\Interfaces;

use App\Models\News;
use Illuminate\Http\Request;

interface INewsRepository
{
    public function create(array $payload): News;
    public function findById(int $id);
    public function update(int $id, array $payload);
    public function delete(int $id);
    public function getAll();
    public function getNewsWithRelations(Request $request);
}
