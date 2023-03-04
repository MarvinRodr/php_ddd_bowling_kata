<?php

namespace App\Tests\Features;

use GuzzleHttp\Client;
use PHPUnit\Framework\TestCase;

abstract class FeatureTestCase extends TestCase
{
    protected Client $client;

    protected function setUp(): void
    {
        parent::setUp();

        $this->client = new Client([
            'base_uri' => 'http://localhost:8040',  // <-- base_uri instead of base_url
        ]);
    }
}
