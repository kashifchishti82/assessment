<?php

namespace App\News\Channels;

use App\News\Contracts\NewsContract;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;

class NewsAPIGateway implements NewsContract
{
    private function fetch()
    {
        $apiKey = config('news.newsapiorg_api_key');
        if (!$apiKey) {
            throw new \Exception('NewsAPI.org API key not found');
        }
        return Http::get('https://newsapi.org/v2/everything', [
            'apiKey' => $apiKey,
            'sources' => 'techcrunch',
            'from' => Carbon::now()->subDays(1)->format('Y-m-d'),
        ]);
    }

    public function getNews()
    {
        return $this->fetch()->json();
    }
}
