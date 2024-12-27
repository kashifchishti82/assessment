<?php

namespace App\Repositories;

use App\Interfaces\ISourceRepository;
use App\Models\Source;
use App\News\Resolvers\NewsChannels;

class SourceRepository implements ISourceRepository
{
    public function __construct(private Source $source){
        // nothing to do here for now
    }
    public function getAllSources()
    {
        return $this->source->all();
    }

    public function getSourceById(int $id)
    {
        // TODO: Implement getSourceById() method.
    }

    public function findOrCreateSource(NewsChannels $channel)
    {
        return $this->source->firstOrCreate(['name' => $channel]);
    }

    public function create(array $payload)
    {
        // TODO: Implement create() method.
    }

    public function update(int $id, array $payload)
    {
        // TODO: Implement update() method.
    }

    public function delete(int $id)
    {
        // TODO: Implement delete() method.
    }
}
