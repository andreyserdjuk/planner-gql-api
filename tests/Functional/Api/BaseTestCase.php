<?php

namespace Planner\Tests\Functional\Api;

use Doctrine\Common\DataFixtures\Purger\ORMPurger;
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
            __DIR__ . '/fixtures/task_priority.yaml',
            __DIR__ . '/fixtures/task_status.yaml',
            __DIR__ . '/fixtures/task.yaml',
        ],
            false,
            null,
            'doctrine',
            ORMPurger::PURGE_MODE_TRUNCATE
        );
    }

    protected function execGraphQL(string $query, array $variables): array
    {
        static::$client->request('POST', '/', [], [], ['CONTENT_TYPE' => 'application/json'], json_encode([
            'query' => $query,
            'variables' => $variables,
        ]));
        $rawResponse = self::$client->getResponse()->getContent();
        $response = json_decode($rawResponse, true);
        $this->assertArrayHasKey('data', $response);

        return $response;
    }
}
