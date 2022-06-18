<?php

namespace App\Http\Controllers;

use App\Events\ImageDelete;
use App\Events\NewsShowCounter;
use App\Http\Controllers\Helpers\ImageTransfer;
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
        $currentPage = request()->get('page', 1);
        $news = Cache::tags('newsList')
            ->remember(
                'news.list.' . $currentPage,
                self::LIST_TTL,
                function () {
                    return News::with('category')
                        ->orderBy('created_at', 'desc')
                        ->paginate(15);
                }
            );
        return view('News.index', compact('news'))
            ->with('i', (request()->input('page', 1) - 1) * 15);
    }

    public function show(string $uuid): View
    {
        $news = Cache::tags('news.show')
            ->remember(
                'news.show.' . $uuid,
                self::LIST_TTL,
                function () use ($uuid) {
                    return News::getByUuid($uuid);
                }
            );
        NewsShowCounter::dispatch($news);
        return view('News.show', compact('news'));
    }

    public function edit(string $uuid): View
    {
        return view(
            'News.edit',
            [
                'news' => News::getByUuid($uuid),
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
            $news->category()
                ->associate(Category::find($request->input('category_id')));
            if ($request->file('image')) {
                $path = ImageTransfer::transfer(
                    $news,
                    $request->file('image'),
                    'photos'
                );
                if ($path) {
                    $news->image = $path;
                }
            };
            $news->save();
            Cache::put('news.show.' . $news->id, $news, self::LIST_TTL);
            Cache::tags('newsList')->flush();
            return redirect()->route('news.index')->with('success', 'Entry created');
        };
        return back()->with('failure', 'Something went wrong');
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
                    $path = ImageTransfer::transfer(
                        $news,
                        $request->file('image'),
                        'photos'
                    );
                    if ($path) {
                        $news->image = $path;
                    }
                }
                $news->category()
                    ->associate(Category::find($request->input('category_id')));
                $news->save();
                Mail::to(env('ADMIN_EMAIL'))
                    ->queue((new NewsCreated($news))->onQueue('emails'));
                Cache::tags('newsList')->flush();
                return redirect()->route('news.index');
            }
            return back()->withInput();
        };
        return back();
    }

    public function destroy(string $uuid): RedirectResponse
    {
        $news = News::getByUuid($uuid);
        if ($news->delete()) {
            Cache::tags('newsList')->flush();
            return back()
                ->with('success', 'Entry ' . $news->title . ' deleted successfully');
        }
        return back()->with('failure', 'Something went wrong');
    }
}
