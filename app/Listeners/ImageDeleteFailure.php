<?php

namespace App\Listeners;

use App\Events\ImageDelete;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class ImageDeleteFailure
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
     * @param  \App\Events\ImageDelete  $event
     * @return void
     */
    public function handle(ImageDelete $event)
    {
        file_put_contents(storage_path() . '/logs/imageDeleteError.log', json_encode($event->throw));
    }
}
