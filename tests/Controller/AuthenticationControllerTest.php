<?php

namespace App\Tests\Controller;

use App\Controller\AuthenticationController;
use PHPUnit\Framework\TestCase;
use GuzzleHttp;

class AuthenticationControllerTest extends TestCase
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

  public function logInAndGetToken(): string
  {
    $response = $this->http->request('POST', 'login', [
      'json' =>
      ['email' => 'Automated@test.chargeports.com',
      'password' => 'Test11@fgh'
      ]
    ]);
    $body = json_decode($response->getBody()->getContents());
    return (string)$body->token;
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

  public function testMe()
  {
    $response = $this->http->request('GET', 'me', ['headers' => ['x-api-key' => $this->logInAndGetToken()]]);
    $this->assertEquals(200, $response->getStatusCode());
  }

}

