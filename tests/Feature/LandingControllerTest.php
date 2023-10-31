<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Http\Controllers\LandingController;
use Illuminate\View\View;

class LandingControllerTest extends TestCase
{
    /**
     * A basic feature test example.
     */

    public function testIndexReturnsView()
    {
        $controller = new LandingController();
        $response = $controller->index();

        $this->assertInstanceOf(View::class, $response);
        $this->assertEquals('welcome', $response->getName());
    }
}
