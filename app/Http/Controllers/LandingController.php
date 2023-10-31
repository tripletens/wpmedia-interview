<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use jcobhams\NewsApi\NewsApi;
use GuzzleHttp\Client;

class LandingController extends Controller
{
    //

    public function index(){

        // I registered on https://newsapi.org/ and got an api key so i could fetch news for the landing page

        $api_key = env('NEWS_API_KEY');

        $newsSource = 'cnn';

        $client = new Client();

        $response = $client->get("https://newsapi.org/v2/everything", [
            'query' => [
                'apiKey' => $api_key,
                'sources' => $newsSource,
            ],
        ]);

        $news = json_decode($response->getBody()->getContents(), true);

        // return gettype($news);

        return view('welcome')->with(['news' => $news]);
    }

}
