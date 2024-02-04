<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\News;
use Carbon\Carbon;

class BreakingNews extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'breaking:news';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update Breaking News';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $newses = News::where('breaking_news','!=',NULL)->get();
        foreach ($newses as $news) {
            $timeDiff = ((\Carbon\Carbon::now('Asia/Kolkata')->diffInMinutes(\Carbon\Carbon::parse($news->added_at))) - ($news->breaking_news));
            if($timeDiff > 0) {
                News::where('id',$news->id)->update(
                    [
                        'breaking_news' => NULL
                    ]
                );
            }
        }
    }
}
