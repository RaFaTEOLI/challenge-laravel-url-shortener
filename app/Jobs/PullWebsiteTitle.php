<?php

namespace App\Jobs;

use App\Models\Shorten;
use App\Repositories\Shorten\ShortenRepository;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class PullWebsiteTitle implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $url;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($url)
    {
        $this->url = $url;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $str = file_get_contents($this->url);
        if (strlen($str) > 0) {
            $str = trim(preg_replace('/\s+/', ' ', $str));
            preg_match("/\<title\>(.*)\<\/title\>/i", $str, $title);
            (new ShortenRepository())->updateWebsiteTitleByUrl($this->url, $title[1]);
        }
    }
}
