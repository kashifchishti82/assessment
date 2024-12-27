<?php

namespace App\Services;

use App\Interfaces\IAuthorRepository;
use App\Interfaces\INewsRepository;
use App\Interfaces\INewsService;
use App\Interfaces\ISourceRepository;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class NewsService implements INewsService
{
    public function __construct(
        private INewsRepository $newsRepository,
        private IAuthorRepository $authorRepository,
        private ISourceRepository $sourceRepository
    ) {
        // Nothing to do here for now.
    }

    public function getAllNewsByFilters()
    {
        return [
            'authors' => $this->authorRepository->getAllAuthors()->select('name', 'id'),
            'sources' => $this->sourceRepository->getAllSources()->select('name', 'id'),
        ];
    }

    public function getAllNews(Request $request)
    {
        return $this->newsRepository->getNewsWithRelations($request);
    }
    public function getById(int $id)
    {
        // TODO: Implement getById() method.
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

    public function getNewsFilters(int $id)
    {
        // TODO: Implement getNewsFilters() method.
    }

    public function importScrappedNews(array $payload, $channel)
    {
        try {
            $source = $this->sourceRepository->findOrCreateSource($channel);
            DB::beginTransaction();
            if ($payload && is_array($payload)) {
                foreach ($payload as $item) {
                    $author = Arr::get($item, 'author', null);
                    $images = Arr::get($item, 'images', null);
                    $item['source_id'] = $source->id;
                    $news = $this->newsRepository->create(Arr::only($item, ['title', 'content', 'published_at', 'source_id']));
                    if ($author) {
                        $authors = $this->authorRepository->getAuthorByNames($author);
                        $news->authors()->attach($authors);
                    }
                    if ($images && is_array($images)) {
                        $news->images()->createMany($images);
                    }
                }
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception($e->getMessage());
        }
    }
}
