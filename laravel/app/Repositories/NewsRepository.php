<?php

namespace App\Repositories;

use App\Interfaces\INewsRepository;
use App\Models\News;
use Illuminate\Http\Request;

class NewsRepository implements INewsRepository
{
    public function __construct(private News $model)
    {
        // Nothing here so far
    }

    public function create(array $payload): News
    {
        return $this->model->create($payload);
    }

    public function findById(int $id)
    {
        // TODO: Implement findById() method.
    }

    public function update(int $id, array $payload)
    {
        // TODO: Implement update() method.
    }

    public function delete(int $id)
    {
        // TODO: Implement delete() method.
    }

    public function getAll()
    {
        return $this->model->all();
    }

    public function getNewsWithRelations(Request $request)
    {
        $news = $this->model->with([
            'authors' => function ($query) {
                $query->select('authors.name');
            },
            'source',
            'images'
        ]);
        if ($request->has('order_by')) {
            $news->orderByPublishedAt($request->get('order_by'));
        }
        if ($request->has('source_id')) {
            $news->source($request->get('source_id'));
        }
        if ($request->has('author_id')) {
            $news->author($request->get('author_id'));
        }
        if($request->has('search')){
            $news->title($request->get('search'));
        }
        return $news->get();
    }
}
