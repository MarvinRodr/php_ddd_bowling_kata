<?php

declare(strict_types=1);

namespace App\Tests\Features\Players;

use App\Tests\Features\FeatureTestCase;
use Exception;
use GuzzleHttp\Exception\GuzzleException;
use Symfony\Component\HttpFoundation\Response;

final class PostLaunchControllerTest extends FeatureTestCase
{
    public function test_should_create_a_launch_and_response_ok(): void
    {
        try {
            $response = $this->client->request(
                'POST',
                '/api/player/launch',
                [
                    'json' => [
                        "id" => null,
                        "player_id" => $this->given_a_existing_player(),
                        "first_one" => 4,
                        "second_one" => 3,
                        "third_one" => 0,
                        "num_frame" => 1
                    ]
                ]
            );

            $stausCode = $response->getStatusCode();
            $this->assertEquals(Response::HTTP_CREATED, $stausCode);
        } catch (GuzzleException $e) {
            echo('ERROR => ' .$e->getMessage(). PHP_EOL);
        }
    }

    public function test_should_not_create_a_launch_and_response_with_bad_request(): void
    {
        try {
            $this->client->request(
                'POST',
                '/api/player/launch',
                [
                    'json' => [
                        'id' => null,
                        'player_id' => "F",
                        "first_one" => 4,
                        "second_one"=> 3,
                        "third_one" => 0,
                        "num_frame"=> null
                    ]
                ]
            );
        } catch (GuzzleException $e) {
            $this->assertEquals(Response::HTTP_BAD_REQUEST, $e->getCode());
        } catch (Exception $e) {
            echo('ERROR => ' .$e->getMessage(). PHP_EOL);
        }
    }

    /**
     * Get the new player ID.
     * @return string
     */
    public function given_a_existing_player(): string
    {
        $playerId = "";
        try {
            $response = $this->client->request(
                'POST',
                '/api/player',
                [
                    'json' => [
                        'id' => null,
                        'name' => "Marvin Bowling",
                    ]
                ]
            );

            $data = json_decode($response->getBody()->getContents(), true);
            $playerId = $data['id'];
        } catch (GuzzleException $e) {
            echo('ERROR => ' .$e->getMessage(). PHP_EOL);
        } catch (Exception $e) {
            echo('ERROR => ' .$e->getMessage(). PHP_EOL);
        }

        return $playerId;
    }
}
