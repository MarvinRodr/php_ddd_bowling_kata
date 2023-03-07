<?php

declare(strict_types=1);

namespace App\Tests\Features\HealCheck;

use App\Tests\Features\FeatureTestCase;
use GuzzleHttp\Exception\GuzzleException;
use Symfony\Component\HttpFoundation\Response;

final class PostPlayerControllerTest extends FeatureTestCase
{
    public function test_should_create_a_player_and_response_ok(): void
    {
        try {
            $response = $this->client->request(
                'POST',
                '/player',
                [
                    'json' => [
                        'id' => null,
                        'name' => "Marvin Bowl",
                    ]
                ]
            );

            $stausCode = $response->getStatusCode();
            $this->assertEquals(Response::HTTP_CREATED, $stausCode);
        } catch (GuzzleException $e) {
            echo('ERROR => ' .$e->getMessage(). PHP_EOL);
        }
    }

    public function test_should_not_create_a_player_and_response_with_bad_request(): void
    {
        try {
            $this->client->request(
                'POST',
                '/player',
                [
                    'json' => [
                        'id' => null,
                        'name' => null,
                    ]
                ]
            );
        } catch (GuzzleException $e) {
            $this->assertEquals(Response::HTTP_BAD_REQUEST, $e->getCode());
        } catch (\Exception $e) {
            echo('ERROR => ' .$e->getMessage(). PHP_EOL);
        }
    }
}
