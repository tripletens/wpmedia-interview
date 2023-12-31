<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Log\Logger;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
class CrawlJob extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:crawl-job';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // run the site crawl job
        // Send a post request to the controller action

        try {
            $app_url = env('APP_URL'); // this is the home page

            $code = Str::random(10);

            $response = Http::post(env('APP_URL') . '/analyze_link', [$app_url, $code]);

            if ($response->successful()) {
                Log::info('Crawl / analysis feature run successfully');
            } else {
                Log::info('Crawl / analysis feature execution failed');
            }
        } catch (\Exception $e) {
            // Log the error
            Log::error($e);
        }
    }
}
