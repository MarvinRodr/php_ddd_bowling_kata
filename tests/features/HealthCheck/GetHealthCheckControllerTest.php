<?php

namespace App\Tests\Features\HealCheck;

use GuzzleHttp\Exception\GuzzleException;
use PHPUnit\Framework\TestCase;
use GuzzleHttp\Client;

final class GetHealthCheckControllerTest extends TestCase
{
    private Client|null $client;

    protected function setUp(): void
    {
        parent::setUp();

        $this->client = new Client([
            'base_uri' => 'http://localhost:8040',  // <-- base_uri instead of base_url
        ]);
    }

    public function test_api_status_should_be_ok(): void
    {
        try {
            $response = $this->client->request('GET', '/health-check');

            $stausCode = $response->getStatusCode();
            $body = json_decode($response->getBody()->getContents(), true);
            $randNum = 0;

            if (is_array($body)) {
                $randNum = (int) $body['rand'];
            }

            $this->assertEquals(200, $stausCode);
            $this->assertEquals(1, $randNum);
        } catch (GuzzleException $e) {
            dd($e->getMessage());
        }
    }
}
