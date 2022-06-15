<?php

namespace App\Listeners;

use App\Events\NewsShowCounter;
use App\Models\News;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Cache;

class NewsShow
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\NewsShowCounter  $event
     * @return void
     */
    public function handle(NewsShowCounter $event)
    {
        $event->news->view_count++;
        $event->news->save();
        Cache::put('news.show.' . $event->news->id, $event->news);
    }
}
