<?php

namespace App\Console\Commands;

use App\Interfaces\INewsService;
use App\News\Resolvers\NewsChannels;
use App\News\ResponseTransformer;
use Illuminate\Console\Command;

class ScrapLatestNews extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:scrap-latest-news';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * @param INewsService $newsService
     */
    public function __construct(protected INewsService $newsService){
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        foreach (NewsChannels::cases() as $channel) {
            try{
                $gateway = $channel->resolve();
                if($gateway){
                    $news = (new ResponseTransformer($channel, $gateway))->transform();
                    $this->newsService->importScrappedNews($news, $channel);
                }
            }catch(\Exception $e){
                logger($e->getMessage(), [
                    'channel' => $channel,
                    'stack' => $e->getTraceAsString(),
                ]);
                $this->error($e->getMessage());
            }


        }
    }
}
