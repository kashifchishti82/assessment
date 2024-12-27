<?php

namespace App\News;

use App\News\Contracts\NewsContract;
use App\News\Resolvers\NewsChannels;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class ResponseTransformer
{
    private $channel;
    private $news;

    public function __construct(NewsChannels $channel, NewsContract $news)
    {
        $this->channel = $channel;
        $this->news = $news;
    }

    public function transform(): array
    {
        $response = $this->news->getNews();
        switch ($this->channel) {
            case NewsChannels::THE_GUARDIAN:
                return $this->getGuardianMappedNews($response);
                break;
            case NewsChannels::NEWS_API:
                return $this->getNewsAPIMappedNews($response);
                break;
            case NewsChannels::NYTIMES:
                return $this->getNYTimesMappedNews($response);
                break;
            default:
                return [];
                break;
        }
    }

    public function getGuardianMappedNews(array $response): array
    {
        $mapped_news = [];
        $response = Arr::get($response, 'response', []);
        if (!empty($response) && is_array($response) && Arr::get($response, 'status') == 'ok') {
            $results = Arr::get($response, 'results');
            foreach ($results as $key => $value) {
                $mapped_news[] = [
                    'title' => Arr::get($value, 'webTitle'),
                    'content' => null, // Not available in Guardian API response
                    'author' => null, // Not available in Guardian API response
                    'published_at' => Arr::get($value, 'webPublicationDate'),

                ];
            }
        }
        return $mapped_news;
    }

    public function getNewsAPIMappedNews(array $response): array
    {
        $mapped_news = [];
        if (!empty($response) && is_array($response) && Arr::get($response, 'status') == 'ok') {
            $results = Arr::get($response, 'articles', []);
            foreach ($results as $key => $value) {
                $mapped_news[] = [
                    'title' => Arr::get($value, 'title'),
                    'content' => Arr::get($value, 'content'),
                    'author' => (function () use ($value) {
                        $author = Arr::get($value, 'author');
                        if ($author) {
                            $parts = explode(',', $author);
                            return $parts;
                        }
                        return null;
                    })(),
                    'published_at' => Arr::get($value, 'publishedAt'),
                    'images' => [
                        [
                            'url' => Arr::get($value, 'urlToImage')
                        ]
                    ]
                ];
            }
        }
        return $mapped_news;
    }

    public function getNYTimesMappedNews(array $response): array
    {
        $mapped_news = [];

        if (!empty($response) && is_array($response) && Arr::get($response, 'status') == 'OK') {
            $results = Arr::get($response, 'results', []);
            foreach ($results as $key => $value) {
                $media = Arr::get($value, 'multimedia', []);
                $mapped_news[] = [
                    'title' => Arr::get($value, 'title'),
                    'content' => Arr::get($value, 'abstract'),
                    'author' => (function () use ($value) {
                        $byline = Arr::get($value, 'byline', null);
                        if ($byline) {
                            $parts = explode('and', $byline);
                            $parts[0] = trim(Str::chopStart($parts[0], "By"));
                            if (count($parts) > 1) {
                                $parts[1] = trim($parts[1]);
                            }
                            return $parts;
                        }
                        return null;
                    })(),
                    'published_at' => Arr::get($value, 'published_date'),
                    'images' => ($media) ? array_map(function ($image) {
                        return [
                            'url' => $image['url']
                        ];
                    }, $media) : []
                ];
            }
        }
        return $mapped_news;
    }

}
