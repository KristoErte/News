<?php

namespace App\Console\Commands;

use App\Article;
use Carbon\Carbon;
use DOMDocument;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class dataUpdate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'dataUpdate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
     * @return mixed
     */
    public function handle()
    {
        $feed_url = "https://www.err.ee/rss";
        $rss = new DOMDocument();
        $rss->load($feed_url);
        $feed = array();

        $lastRecordTime = (DB::table('articles')->count() == 0)
            ? $lastRecordTime = Carbon::create(2000, 1, 1, 1, 1, 1)
            : $lastRecordTime = Carbon::parse(DB::table('articles')->latest('created_at')->first()->created_at);

        $rssLastUpdateTime = Carbon::parse($rss->getElementsByTagName('lastBuildDate')->item(0)->nodeValue);
        if ($rssLastUpdateTime->greaterThan($lastRecordTime)) {
            foreach ($rss->getElementsByTagName('item') as $node) {
                $pubDate = Carbon::parse($node->getElementsByTagName('pubDate')->item(0)->nodeValue);

                if ($pubDate->greaterThan($lastRecordTime)) {
                    $article = new Article();
                    $article->title = $node->getElementsByTagName('title')->item(0)->nodeValue;
                    $article->desc = $node->getElementsByTagName('description')->item(0)->nodeValue;
                    $article->link = $node->getElementsByTagName('link')->item(0)->nodeValue;
                    $article->date = Carbon::parse($node->getElementsByTagName('pubDate')->item(0)->nodeValue);
                    $article->save();
                    $item = array(
                        'title' => $node->getElementsByTagName('title')->item(0)->nodeValue,
                        'desc' => $node->getElementsByTagName('description')->item(0)->nodeValue,
                        'link' => $node->getElementsByTagName('link')->item(0)->nodeValue,
                        'date' => $node->getElementsByTagName('pubDate')->item(0)->nodeValue,
                    );
                    $content = $node->getElementsByTagName('encoded');
                    if ($content->length > 0) {
                        $item['content'] = $content->item(0)->nodeValue;
                    }
                    array_push($feed, $item);
                }
            }
        }
    }
}
