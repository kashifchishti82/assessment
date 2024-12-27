<?php

namespace App\Http\Controllers;

use App\Interfaces\INewsService;
use Illuminate\Http\Request;

class NewsController extends Controller
{

    public function getFilters(INewsService $newsService)
    {
        return response()->json($newsService->getAllNewsByFilters(), 200);
    }
    public function allNews(INewsService $newsService, Request $request)
    {
        return response()->json($newsService->getAllNews($request), 200);
    }
}
