<?php

namespace App\Tests\Controller;

use App\Controller\AuthenticationController;
use PHPUnit\Framework\TestCase;
use GuzzleHttp;

class AuthenticationControllerTest extends TestCase
{
  private $http;

  public function setUp(): void
  {
    # using 'web' instead of localhost due to docker networking
    $this->http = new GuzzleHttp\Client(['base_uri' => 'http://web/api/']);
  }

  public function tearDown(): void
  {
    $this->http = null;
  }

  public function testRegister()
  {
    $response = $this->http->request('POST', 'register', [
      'json' =>
      ['email' => 'Automated@test.chargeports.com',
      'firstName' => 'automated',
      'lastName' => 'test',
      'password' => 'Test11@fgh'
      ]
    ]);

    $this->assertEquals(200, $response->getStatusCode());
  }

  public function testLogin()
  {
    $response = $this->http->request('POST', 'login', [
      'json' =>
      ['email' => 'Automated@test.chargeports.com',
      'password' => 'Test11@fgh'
      ]
    ]);

    $this->assertEquals(200, $response->getStatusCode());
  }

#  public function testMe()
#  {
#    $response = $this->http->request('GET', 'me', 
#      ['auth' => ['automated@test.chargeports.com', 'Test11@fgh']]);
#    $this->assertEquals(200, $response->getStatusCode());
#  }

}

