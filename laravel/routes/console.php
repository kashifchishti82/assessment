<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

\Illuminate\Support\Facades\Schedule::command(\App\Console\Commands\ScrapLatestNews::class)->hourly();
