<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\NewsRequest;
use App\Http\Resources\NewsResource;
use App\Models\News;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cache;

class NewsApiController extends Controller
{
    private const CACHE_TTL = 3600;

    public function index()
    {
        // dd(News::with('category')->get());
        return NewsResource::collection(News::with('category')->get());
    }

    public function show(string $uuid): NewsResource|Response
    {
        $news = Cache::tags('news.show')->remember('api.news.' . $uuid, self::CACHE_TTL, function() use ($uuid){
            return News::uuid($uuid);
        });
        if ($news !== null) {
            return new NewsResource($news);
        }
        return response(['error' => 'News don\'t exist'], 404);
    }
}
