<?php

namespace App\News\Channels;

use App\News\Contracts\NewsContract;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;

class TheGuardianGateway implements NewsContract
{
    private function fetch()
    {
        $apiKey = config('news.guardian_api_key');
        if (!$apiKey) {
            throw new \Exception('Guardian API key not found');
        }
        return Http::get('https://content.guardianapis.com/search', [
            'api-key' => $apiKey,
            'tag' => 'politics/politics',
            'q' => 'debate'
        ]);
    }

    public function getNews()
    {
        return $this->fetch()->json();
    }
}
