<?php

namespace App\Mail;

use App\Http\Resources\NewsCollection;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewsToday extends Mailable
{
    use Queueable;
    use SerializesModels;

    protected Collection $newsCollection;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Collection $collection)
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
            ->with(['data' => new NewsCollection($this->newsCollection)])
            ->from('noreply@thisapp.net')
            ->tag('News created today')
            ->markdown('emails.news.newsToday');
    }
}
