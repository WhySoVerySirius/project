<?php

namespace App\Console\Commands;

use App\Http\Resources\TodaysNewsResource;
use App\Mail\NewsToday;
use App\Models\News;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class MailTodaysNews extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:mailTodaysNews';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Mail todays news';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $todaysNews = News::where(
            [
                [
                    'created_at', '>', Carbon::today()->startOfDay()
                ],
                [
                    'created_at', '<', Carbon::today()->endOfDay()
                ]
            ]
        )
        ->get();
        Mail::to(env('ADMIN_EMAIL'))->queue((new NewsToday($todaysNews))->onQueue('emails'));
    }
}
