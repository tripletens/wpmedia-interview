<?php

namespace Tests\Feature;

use App\Http\Controllers\DashboardController;
use Goutte\Client;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Request;
use Tests\TestCase;
use Illuminate\View\View;
use Illuminate\Support\Facades\Storage;
use App\Models\Results;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\ValidationException;
use App\Models\User;
use Illuminate\Http\RedirectResponse;

class DashboardControllerTest extends TestCase
{
    use WithFaker, RefreshDatabase;
    // check if the index returns a view
    public function test_check_if_index_returns_view()
    {
        $controller = new DashboardController();
        $response = $controller->index();

        $this->assertInstanceOf(View::class, $response);
        $this->assertEquals('dashboard', $response->getName());
    }

    // check if the analyse function has a valid url
    // public function test_check_if_analyse_has_valid_url()
    // {
    //     // Mock the request with a valid URL
    // $request = Request::create('/analyze-link', 'POST', ['url' => 'https://example.com']);

    // // Mock the Goutte client and crawler
    // $client = $this->createMock(Client::class);
    // $crawler = $this->createMock(\Symfony\Component\DomCrawler\Crawler::class);
    // $client->expects($this->once())->method('request')->willReturn($crawler);
    // $crawler->expects($this->once())->method('filter')->willReturn($crawler);
    // $crawler->expects($this->once())->method('links')->willReturn([]);

    // $controller = $this->getMockBuilder(DashboardController::class)
    //     ->onlyMethods(['delete_last_crawl', 'save_link', 'delete_home_page_file', 'delete_site_map_file'])
    //     ->getMock();

    // $controller->expects($this->once())->method('delete_last_crawl')->willReturn(true);
    // $controller->expects($this->once())->method('save_link')->willReturn(true);
    // $controller->expects($this->once())->method('delete_home_page_file');
    // $controller->expects($this->once())->method('delete_site_map_file');

    // $response = $controller->analyze_link($request);

    // $this->assertEquals(302, $response->getStatusCode());
    // $this->assertSessionHas('success');
    // }

    public function testIndexReturnsView()
    {
        $controller = new DashboardController();
        $response = $controller->index();

        $this->assertInstanceOf(View::class, $response);
        $this->assertEquals('dashboard', $response->getName());
    }

    // public function testAnalyzeLinkWithValidUrl()
    // {
    //     // Mock the request with a valid URL
    //     $request = Request::create('/analyze-link', 'POST', ['url' => 'https://example.com']);

    //     // Mock the Goutte client and crawler
    //     $client = $this->createMock(Client::class);
    //     $crawler = $this->createMock(\Symfony\Component\DomCrawler\Crawler::class);
    //     $client->expects($this->once())->method('request')->willReturn($crawler);
    //     $crawler->expects($this->once())->method('filter')->willReturn($crawler);
    //     $crawler->expects($this->once())->method('links')->willReturn([]);

    //     $controller = $this->getMockBuilder(DashboardController::class)
    //         ->onlyMethods(['delete_last_crawl', 'save_link', 'delete_home_page_file', 'delete_site_map_file'])
    //         ->getMock();

    //     $controller->expects($this->once())->method('delete_last_crawl')->willReturn(true);
    //     $controller->expects($this->once())->method('save_link')->willReturn(true);
    //     $controller->expects($this->once())->method('delete_home_page_file');
    //     $controller->expects($this->once())->method('delete_site_map_file');

    //     $response = $controller->analyze_link($request);

    //     $this->assertEquals(302, $response->getStatusCode());
    //     $this->assertSessionHas('success');
    // }

    // public function testAnalyzeLinkWithInvalidUrl()
    // {
    //     // Mock the request with an invalid URL
    // $request = Request::create('/analyze-link', 'POST', ['url' => 'invalid-url']);

    // $controller = $this->getMockBuilder(DashboardController::class)
    //     ->onlyMethods(['delete_last_crawl', 'save_link', 'delete_home_page_file', 'delete_site_map_file'])
    //     ->getMock();

    // $controller->expects($this->never())->method('delete_last_crawl');
    // $controller->expects($this->never())->method('save_link');
    // $controller->expects($this->once())->method('delete_home_page_file');
    // $controller->expects($this->once())->method('delete_site_map_file');

    // $response = $controller->analyze_link($request);

    // $this->assertEquals(302, $response->getStatusCode());
    // $this->assertSessionHasErrors(['url']); // Use assertSessionHasErrors for validation errors
    // }

    // public function testResults()
    // {
    //     $controller = new DashboardController();

    //     // Mock the Results model to return some sample data for testing
    //     // $results = [];
    //     $results = [
    //         [
    //             "id" => 5, "url" => "https:\/\/wpmedia-interview.test\/login",
    //             "created_at" => "2023-10-25T12:56:25.000000Z",
    //             "updated_at" => "2023-10-25T12:56:25.000000Z",
    //             "deleted_at" => null, "code" => "3tSENzM20Q"
    //         ]
    //     ];
    //     $mockResults = $this->mock(Results::class);
    //     $mockResults->shouldReceive('all')->andReturn($results);

    //     $controller = new DashboardController();

    //     $response = $controller->results();

    //     $this->assertTrue($response->original->getData()['results']->contains($results[0])); // Check if the data contains your sample data
    // }

    // public function testResultsWithResults()
    // {
    //     // Mock the Results model to return some sample data for testing
    //     $results = [
    //         [
    //             "id" => 5, "url" => "https:\/\/wpmedia-interview.test\/login",
    //             "created_at" => "2023-10-25T12:56:25.000000Z",
    //             "updated_at" => "2023-10-25T12:56:25.000000Z",
    //             "deleted_at" => null, "code" => "3tSENzM20Q"
    //         ]
    //     ];

    //     $mockResults = $this->mock(Results::class);
    //     $mockResults->shouldReceive('all')->andReturn($results);

    //     $controller = new DashboardController();

    //     $response = $controller->results();

    //     $response->assertViewIs('results');
    //     $response->assertViewHas('results', $response);
    // }


    public function testSaveLink()
    {
        $controller = new DashboardController();
        $link = env('APP_URL');
        $code = 'random_code';

        // Mock the Results model
        $mockResults = $this->mock(Results::class);
        $mockResults->shouldReceive('create')->with(['url' => $link, 'code' => $code])->andReturn(new Results());

        $result = $controller->save_link($link, $code);

        $this->assertTrue($result);
    }

    // public function testDeleteLastCrawl()
    // {
    //     $controller = new DashboardController();

    //     // Mock the Results model to return some sample data for testing
    //     $results = [
    //         [
    //             "id" => 5, "url" => "https:\/\/wpmedia-interview.test\/login",
    //             "created_at" => "2023-10-25T12:56:25.000000Z",
    //             "updated_at" => "2023-10-25T12:56:25.000000Z",
    //             "deleted_at" => null, "code" => "3tSENzM20Q"
    //         ]
    //     ];

    //     $mockResults = $this->mock(Results::class);
    //     $mockResults->shouldReceive('all')->andReturn($results);
    //     $mockResults->shouldReceive('delete')->times(count($results));

    //     $result = $controller->delete_last_crawl();

    //     $this->assertTrue($result);
    // }

    // public function testDeleteLastCrawl()
    // {
    //     $controller = new DashboardController();

    //     // Mock the Results model to return some sample data for testing
    //     $results = [
    //         [
    //             "id" => 5, "url" => "https:\/\/wpmedia-interview.test\/login",
    //             "created_at" => "2023-10-25T12:56:25.000000Z",
    //             "updated_at" => "2023-10-25T12:56:25.000000Z",
    //             "deleted_at" => null, "code" => "3tSENzM20Q"
    //         ]
    //     ];
    //     $mockResults = $this->mock(Results::class);

    //     // Set the expectation that delete will be called for each item in $results
    //     $mockResults->shouldReceive('delete')->times(count($results));

    //     $response = $controller->delete_last_crawl();

    //     $this->assertTrue($response);
    // }

    public function testDeleteLastCrawl()
    {
        $results = [
            new Results([
                "id" => 5, "url" => "https:\/\/wpmedia-interview.test\/login",
                "created_at" => "2023-10-25T12:56:25.000000Z",
                "updated_at" => "2023-10-25T12:56:25.000000Z",
                "deleted_at" => null, "code" => "3tSENzM20Q"
            ]),
            new Results([
                "id" => 6, "url" => "https:\/\/wpmedia-interview.test\/register",
                "created_at" => "2023-10-25T12:56:25.000000Z",
                "updated_at" => "2023-10-25T12:56:25.000000Z",
                "deleted_at" => null, "code" => "3tSENzM20Q"
            ]),
        ];

        $mockResults = $this->mock(Results::class);
        $mockResults->shouldReceive('all')->andReturn($results);

        $controller = new DashboardController();

        $response = $controller->delete_last_crawl();

        $this->assertTrue($response);
    }

    public function testDeleteHomePageFileWhenFileExists()
    {
        // Mock the Storage facade
        Storage::fake('public');
        Storage::disk('public')->put('homepage.html', 'File content');

        $controller = new DashboardController();

        $response = $controller->delete_home_page_file();

        $this->assertTrue($response);

        // Assert that the file was deleted
        $this->assertFalse(Storage::disk('public')->exists('homepage.html'));
    }

    public function testDeleteHomePageFile()
    {
        $controller = new DashboardController();

        // Mock the Storage facade
        Storage::shouldReceive('disk')->with('public')->andReturnSelf();
        Storage::shouldReceive('exists')->with('homepage.html')->andReturn(true);
        Storage::shouldReceive('delete')->with('homepage.html')->andReturn(true);

        $result = $controller->delete_home_page_file();

        $this->assertTrue($result);
    }

    public function testDeleteSiteMapFile()
    {
        $controller = new DashboardController();

        // Mock the Storage facade
        Storage::shouldReceive('disk')->with('public')->andReturnSelf();
        Storage::shouldReceive('exists')->with('sitemap.html')->andReturn(true);
        Storage::shouldReceive('delete')->with('sitemap.html')->andReturn(true);

        $result = $controller->delete_site_map_file();

        $this->assertTrue($result);
    }

    public function testRunCronJobSuccess()
    {
        $controller = new DashboardController();

        // Mock Artisan's call to the 'app:crawl-job' command
        Artisan::shouldReceive('call')->with('app:crawl-job')->once();

        // Create a mock of the response for redirecting back
        $redirectResponse = $this->createMock(\Illuminate\Http\RedirectResponse::class);

        $controller->expects($this->once())->method('redirect')->willReturn($redirectResponse);

        // Assert the response is a success redirect
        $response = $controller->run_cron_job();
        $this->assertSame($redirectResponse, $response);
        $this->assertSessionHas('success');
    }

    // public function testRunCronJobFailure()
    // {
    //     $controller = new DashboardController();

    //     // Mock Artisan's call to the 'app:crawl-job' command to throw an exception
    //     Artisan::shouldReceive('call')->with('app:crawl-job')->andThrow(new \Exception('Cron job failed'));

    //     // Create a mock of the response for redirecting back
    //     $redirectResponse = $this->createMock(\Illuminate\Http\RedirectResponse::class);

    //     $controller->expects($this->once())->method('redirect')->willReturn($redirectResponse);

    //     // Assert the response is an error redirect
    //     $response = $controller->run_cron_job();
    //     $this->assertSame($redirectResponse, $response);
    //     $this->assertSessionHas('error');
    // }
}
