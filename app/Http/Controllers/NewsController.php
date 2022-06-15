<?php

namespace App\Http\Controllers;

use App\Events\ImageDelete;
use App\Events\NewsShowCounter;
use App\Http\Requests\NewsRequest;
use App\Mail\NewsCreated;
use App\Models\Category;
use App\Models\News;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class NewsController extends Controller
{
    private const LIST_TTL = 36000;

    public function index(): View
    {
        $news = News::with('category')->orderBy('created_at', 'desc')->paginate(15);
        return view('News.index', compact('news'))->with('i', (request()->input('page', 1) - 1) * 10);
    }

    public function show(string $id): View
    {
        $news = Cache::remember('news.show.' . $id, self::LIST_TTL, function () use ($id) {
            return News::find($id);
        });
        NewsShowCounter::dispatch($news);
        return view('News.show', compact('news'));
    }

    public function edit(News $news): View
    {
        return view(
            'News.edit',
            [
                'news' => $news,
                'categories' => Category::all(),
            ]
        );
    }

    public function update(NewsRequest $request, News $news): RedirectResponse
    {
        if ($request->isMethod('PUT')) {
            $formData = $request->all();
            $news->update($formData);
            $news->category()->dissociate();
            $news->category()->associate(Category::find($request->input('category_id')));
            if ($request->file('image')) {
                if ($news->image) {
                    try {
                        Storage::delete($news->image);
                    } catch (\Throwable $th) {
                        ImageDelete::dispatch($th);
                    }
                }
                if ($path = Storage::putFile('photos', $request->file('image'))) {
                    $news->image = $path;
                };
            };
            $news->save();
            Cache::put('news.show.' . $news->id, $news, self::LIST_TTL);
            Cache::put('news.list', News::with('category')->get(), self::LIST_TTL);
            return redirect()->route('news.index')->with('success', 'Entry created');
        };
        return back()->with('failure', 'Stuff happened');
    }

    public function create(): View
    {
        return view('News.create', ['categories' => Category::all()]);
    }

    public function store(NewsRequest $request): RedirectResponse
    {
        if ($request->isMethod('POST')) {
            $formData = $request->all();
            if ($formData) {
                $news = News::create($formData);
                if ($request->file('image')) {
                    if ($path = Storage::putFile('photos', $request->file('image'))) {
                        $news->image = $path;
                    };
                }
                $news->category()->associate(Category::find($request->input('category_id')));
                $news->save();
                Mail::to('admin@thisapp.net')->send(new NewsCreated($news));
                return redirect()->route('news.index');
            }
            return back()->withInput();
        };
        return back();
    }

    public function destroy(News $news): RedirectResponse
    {
        $news->delete();
        return redirect()->back()->with('success', 'Entry ' . $news->title . ' deleted successfully');
    }
}
