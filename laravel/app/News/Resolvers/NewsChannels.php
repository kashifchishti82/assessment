<?php

namespace App\News\Resolvers;

use App\News\Channels\NewsAPIGateway;
use App\News\Channels\NYTimes;
use App\News\Channels\TheGuardianGateway;
use App\News\Contracts\NewsContract;

enum NewsChannels
{
    case THE_GUARDIAN;
    case NEWS_API;
    case NYTIMES;

    public function resolve(): NewsContract|null
    {
        return match ($this) {
            self::THE_GUARDIAN => new TheGuardianGateway(),
            self::NEWS_API => new NewsAPIGateway(),
            self::NYTIMES => new NYTimes(),
            default => null
        };
    }

    public static function fromName(string $name): self
    {
        return constant(self::class . '::' . strtoupper($name));
    }

    public function toString(): string
    {
        return match ($this) {
            self::THE_GUARDIAN => 'The Guardian',
            self::NEWS_API => 'News API',
            self::NYTIMES => 'New York Times',
            default => 'Unknown'
        };
    }
}
