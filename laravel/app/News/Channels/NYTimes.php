<?php

namespace App\News\Channels;

use App\News\Contracts\NewsContract;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;

class NYTimes implements NewsContract
{
    private function fetch()
    {
        $api_key = config('news.nytimes_api_key');
        if (!$api_key) {
            throw new \Exception('NYTimes API key not found');
        }
        return Http::get('https://api.nytimes.com/svc/topstories/v2/world.json', [
            'api-key' => $api_key
        ]);
    }

    public function getNews()
    {
        return $this->fetch()->json();
    }
}
