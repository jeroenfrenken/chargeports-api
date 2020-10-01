<?php

namespace App\Tests\Controller;

use App\Controller\AuthenticationController;
use PHPUnit\Framework\TestCase;
use GuzzleHttp;

class AuthenticationControllerTest extends TestCase
{
    private $http;

    public function setUp() : void
    {
        $this->http = new GuzzleHttp\Client(['base_uri' => 'https://httpbin.org/']);
    }

    public function tearDown() : void {
        $this->http = null;
    }

    public function testGet()
    {
        $response = $this->http->request('GET', 'user-agent');

        $this->assertEquals(200, $response->getStatusCode());

        $contentType = $response->getHeaders()["Content-Type"][0];
        $this->assertEquals("application/json", $contentType);

        $userAgent = json_decode($response->getBody())->{"user-agent"};
        $this->assertRegexp('/Guzzle/', $userAgent);
    }

    public function testPut()
    {
        $response = $this->http->request('PUT', 'user-agent', ['http_errors' => false]);

        $this->assertEquals(405, $response->getStatusCode());
    }



}
