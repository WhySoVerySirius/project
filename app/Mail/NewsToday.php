<?php

namespace App\Mail;

use App\Http\Resources\NewsResource;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class NewsToday extends Mailable
{
    use Queueable;
    use SerializesModels;

    protected AnonymousResourceCollection $newsCollection;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(AnonymousResourceCollection $collection)
    {
        $this->newsCollection = $collection;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
            ->with(['data' => NewsResource::collection($this->newsCollection)])
            ->from('noreply@thisapp.net')
            ->tag('News created today')
            ->markdown('emails.news.newsToday');
    }
}
