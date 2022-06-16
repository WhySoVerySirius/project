<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\NewsCollection;
use App\Http\Resources\NewsResource;
use App\Models\News;
use Illuminate\Http\Request;

class NewsApiController extends Controller
{
    public function index(): NewsCollection
    {
        // dd(new NewsCollection(News::all()));
        return new NewsCollection(News::all());
    }

    public function show(string $uuid)
    {
        return new NewsResource(News::uuid($uuid));
    }
}
