<?php

namespace App\Interfaces;

interface INewsService
{
    public function getAllNewsByFilters();
    public function getById(int $id);
    public function create(array $payload);
    public function update(int $id, array $payload);
    public function delete(int $id);
    public function getNewsFilters(int $id);
}
