<?php

namespace App\Interfaces;

use App\News\Resolvers\NewsChannels;

interface ISourceRepository
{
    public function getAllSources();

    public function getSourceById(int $id);

    public function findOrCreateSource(NewsChannels $channel);

    public function create(array $payload);

    public function update(int $id, array $payload);

    public function delete(int $id);
}
