<?php

namespace App\Tests\Functional\Api;

use Liip\TestFixturesBundle\Test\FixturesTrait;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

abstract class BaseTestCase extends WebTestCase
{
    use FixturesTrait;

    protected static KernelBrowser $client;

    protected function setUp(): void
    {
        self::$client = self::createClient();
        $this->loadFixtureFiles([
            __DIR__.'/fixtures/task_priority.yaml',
            __DIR__.'/fixtures/task_status.yaml',
            __DIR__.'/fixtures/task.yaml',
        ]);
    }

    protected static function execGraphQL($operationName, $query, $variables): array
    {
        static::$client->request('POST', '/', [], [], ['CONTENT_TYPE' => 'application/json'], json_encode([
            'operationName' => $operationName,
            'query' => $query,
            'variables' => $variables,
        ]));
        $rawResponse = self::$client->getResponse()->getContent();

        return json_decode($rawResponse, true);
    }
}
