<?php

declare(strict_types=1);

namespace App\Tests\Features\HealCheck;

use App\Tests\Features\FeatureTestCase;
use GuzzleHttp\Exception\GuzzleException;
use Symfony\Component\HttpFoundation\Response;

final class GetHealthCheckControllerTest extends FeatureTestCase
{
    public function test_api_status_should_be_ok(): void
    {
        try {
            $response = $this->client->request('GET', '/api/health-check');

            $stausCode = $response->getStatusCode();
            $body = json_decode($response->getBody()->getContents(), true);
            $randNum = 0;

            if (is_array($body)) {
                $randNum = (int) $body['rand'];
            }

            $this->assertEquals(Response::HTTP_OK, $stausCode);
            $this->assertEquals(1, $randNum);
        } catch (GuzzleException $e) {
            echo('ERROR => ' .$e->getMessage(). PHP_EOL);
        }
    }
}
