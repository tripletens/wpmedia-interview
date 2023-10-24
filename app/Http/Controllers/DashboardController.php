<?php

namespace App\Http\Controllers;

use App\Models\Results;
use Goutte\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class DashboardController extends Controller
{
    //

    public function index(){
        return view('dashboard');
    }

    // check submit link

    public function analyze_link(Request $request)
    {
        try {

            $request->validate([
                'url' => 'required|url',
            ]);

            $url = $request->input('url');

            $client = new Client();

            $crawler = $client->request('GET', $url);

            $internal_links = $crawler->filter('a')->links();

            $code = Str::random(10);

            // delete last crawl

            if(!$this->delete_last_crawl()){
                $delete_last_crawl_error = "Sorry we could not delete the last crawl";

                return redirect()->back()->withErrors(['error' => $delete_last_crawl_error . ' => ' . $this->delete_last_crawl()]);
            };




            // end delete last crawl

            $results = [];

            foreach ($internal_links as $link) {
                $results[] = $link->getUri();
            }

            foreach ($results as $link) {
                $save_link = $this->save_link($link, $code);

                if(!$save_link){
                    $save_link_error_message = "Sorry we could not save - " . $link;
                    return redirect()->back()->withErrors(['error' => $save_link_error_message]);
                }
            }

            // delete home page file

            // if(!$this->delete_home_page_file()){
            //     $file_error_message = "Sorry home page file could not be deleted. Kindly check if file exists";
            //     return redirect()->back()->withErrors(['error' => $file_error_message]);
            // };

            // delete site map file

            if(!$this->delete_site_map_file()){
                $file_error_message = "Sorry site map file could not be deleted. Kindly check if file exists";
                return redirect()->back()->withErrors(['error' => $file_error_message]);
            };

            // Create and save sitemap.html
            $sitemap = view('sitemap', ['results' => $results])->render();

            // Storage::disk('local')->put("public/".$code."/sitemap.xml", $sitemap);

            file_put_contents(public_path('sitemap.html'), $sitemap);

            // Save the homepage as homepage.html
            $homepageHtml = $crawler->html();

            file_put_contents(public_path('homepage.html'), $homepageHtml);


            $save_link_success_message = "Links have been successfully saved";

            return redirect()->back()->with(['success' => $save_link_success_message]);

        } catch (\Exception $e){
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    // fetch all the saved results
    public function results(){
        $results = Results::all();

        if(!$results){
            return redirect()->back()->withErrors(['error' => 'Sorry we could not fetch all the crawled site url']);
        }

        return view('results')->with(['results' => $results]);
    }
    // Save crawled links
    public function save_link($link, $code){
        $save_link = Results::create([
            'url' => $link,
            'code' => $code
        ]);

        if(!$save_link){
            return false;
        }

        return true;
    }

    // Delete previous crawls
    public function delete_last_crawl(){

        try {

            $last_crawl = Results::all();

            foreach ($last_crawl as $item){
                $item->delete();
            }

            return true;

        } catch (\Exception $e){
            return $e->getMessage();
        }
    }

    // Delete home page file
    public function delete_home_page_file(){
        // $home_page_path = public_path('homepage.html');

        // Check if the index.html file exists and delete it
        if (Storage::disk('public')->exists('index.html')) {
            Storage::disk('public')->delete('index.html');
            return true;
        }

        return false;
    }

    // delete site map file
    public function delete_site_map_file(){
        // Check if the index.html file exists and delete it
        if (Storage::disk('public')->exists('sitemap.html')) {
            Storage::disk('public')->delete('index.html');
            return true;
        }

        return false;
    }

    public function run_cron_job()
    {
        \Artisan::call('app:crawl-job');

        // Redirect back to the previous page or to a success page
        return redirect()->back()->with('success', 'Hourly crawling started successfully');
    }
}
