<?php

namespace App\Mail;

use App\Http\Resources\NewsResource;
use App\Models\News;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewsCreated extends Mailable
{
    use Queueable, SerializesModels;

    protected News $news;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(News $news)
    {
        $this->news = $news;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
            ->with(['data' => new NewsResource($this->news)])
            ->from('noreply@info.meh')
            ->tag('News created')
            ->markdown('emails.news.created');
    }
}
