<?php

namespace App\Tests\Controller;

use App\Controller\ChargerController;
use PHPUnit\Framework\TestCase;
use GuzzleHttp;

class ChargerControllerTest extends TestCase
{
  private $http;
  private $token;

    public function setUp(): void
    {
        # using 'web' instead of localhost due to docker networking
        $this->http = new GuzzleHttp\Client(['base_uri' => 'http://web/api/']);
    }

    public function tearDown(): void
    {
        $this->http = null;
    }

    public function testGetCharger()
    {
        $response = $this->http->request('GET', 'charger');
        $this->assertEquals(200, $response->getStatusCode());
    }

}
